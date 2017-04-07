var learningTour = (function () {
    var config = {
        tours: [],
        csrf: '',
        counter: 0,
        currentTour: '',
        toursData: [],
        updateStepPath: '/tours/update-step',
        completeTourPath: '/tours/complete'
    };

    function init(config) {
        _manualStartTour();
        _initConfig(config);
        _initHopscotchListeners();
        _initHopscotch();
    }

    function _initHopscotchListeners() {
        var prev = null;

        hopscotch.listen('show', function () {
            var target = hopscotch.getCurrTarget();
            var targetEl = $(target);
            var helper = $('.helper');


            if(prev) {
                $('#'+prev).removeClass('overlay-relative');
            }
            targetEl.addClass('overlay-relative');

            if ( ! helper.length) {
                // var padding = 5;
                var newHelper = '<div class="helper"></div>';
                $('body').append(newHelper);
                helper = $('.helper');
            }


            // Use Helper Layer for highlight target element.

            var helperPosX = targetEl.offset().left;
            var helperPosY = targetEl.offset().top;
            var targetWidth = targetEl.outerWidth();
            var targetHeight = targetEl.outerHeight();

            helper.css('width', targetWidth);
            helper.css('height', targetHeight);
            helper.offset({left: helperPosX, top: helperPosY});

            prev = target.id;
        });

        hopscotch.listen('start', function () {
            if ( ! $('.overlay').length) {
                $('body').append('<div class="overlay"></div>');
            }
        });

        hopscotch.listen('end', function () {
            _completeTour();
            _clearOverlays();
            _removeListeners();
        });

        hopscotch.listen('show', function () {
            _updateTourStatus();
        });
        hopscotch.listen('close', function () {
            _clearOverlays();
        });
    }

    function _clearOverlays() {
        $('.overlay-relative').each(function () {
            $(this).removeClass('overlay-relative');
        });
        $('.overlay').fadeOut(function () {
            $(this).remove();
            $('.helper').remove();
        });
    }

    function _initConfig(params) {
        config.csrf = params.csrf;
        config.updateStepPath = params.updateStepPath;
        config.completeTourPath = params.completeTourPath;
        _formatTours(params.tours);
    }

    function _initHopscotch() {
        config.currentTour = config.toursData[config.tours[config.counter]];

        if (config.currentTour && ! config.currentTour.completed) {
            _startHopcotch(config.currentTour);
        }

        _buildMenu(config.toursData);
    }

    function _formatTours(data) {
        data.map(function (elem) {
            for (var prop in elem) {
                config.tours.push(prop);

                var tour = elem[prop];

                tour.steps = tour.steps.map(function (step) {
                    return {
                        'id': step.id,
                        'title': step.title,
                        'content': step.content,
                        'target': step.target,
                        'placement': step.placement,
                        'showPrevButton': step.show_prev_button,
                        'showNextButton': step.show_next_button,
                        'nextOnTargetClick': step.next_on_target_click,
                        'route': step.route,
                        'multipage': step.multipage,
                        'onNext': ['fixDropdowns', step, tour]
                    }
                });
                config.toursData[prop] = tour;
            }
        });
    }

    function _updateTourStatus() {
        $.ajax({
            method: 'POST',
            url: config.updateStepPath
                +'/'+config.currentTour.steps[hopscotch.getCurrStepNum()].id,
            data: {
                _token: config.csrf
            }
        });
    }

    function _completeTour() {
        $.ajax({
            method: 'POST',
            url: config.completeTourPath+'/'+config.currentTour.base_id,
            data: {_token: config.csrf}
        });
    }

    function _removeListeners() {
        hopscotch.unlisten('show');
        hopscotch.unlisten('start');
        hopscotch.unlisten('end');
    }

    function _startHopcotch(data) {
        hopscotch.configure({cookieName: 'hopscotch.' + data.id});
        if (data.step == 0 || data.steps[data.step + 1].route == config.currentTour.current_route) {
            hopscotch.startTour(data, data.step);
        }
    }

    /*
     *	Append helper callback for current hopscotch instance
     */
    function appendHelper(helperName, callback) {
        hopscotch.registerHelper(helperName, callback);
    }

    function _buildMenu() {
        var root = $('#learningTour-menu');
        var list = '';
        for (var key in config.toursData) {
            list = list + "<li><a href='#' class='tour-link' data-tour='" + key + "'>"
                + config.toursData[key].name
                + "</a></li>"
        }
        root.append(list);
    }

    function _manualStartTour() {
        $(document).on('click', '.tour-link', function (e) {
            e.preventDefault();
            var tourId = $(this).data('tour');
            config.currentTour = config.toursData[tourId];
            _startHopcotch(config.currentTour);
        });
    }

    return {
        init: init,
        appendHelper: appendHelper
    }
}());
