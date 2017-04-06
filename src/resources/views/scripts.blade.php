<script>
	var fixDropdowns = function (step, tour) {
	    var nextStep = tour.steps[tour.step+1];
	    console.log(nextStep);
        if(step.multipage && nextStep.route == step.route) {
            setTimeout(function () {
                hopscotch.startTour(tour, hopscotch.getCurrStepNum());
            }, 500);
        }
    };

	learningTour.appendHelper('fixDropdowns', fixDropdowns);
    $(document).ready(function () {
        var language = {
            nextBtn: "{{ trans('learningtour::buttons.next') }}",
            prevBtn: "{{ trans('learningtour::buttons.prev') }}",
            doneBtn: "{{ trans('learningtour::buttons.finish') }}",
            skipBtn: "{{ trans('learningtour::buttons.skip') }}",
            closeTooltip: "{{ trans('learningtour::buttons.close') }}"
        };
        hopscotch.configure({i18n: language});
        var config = {
            csrf: "{{ csrf_token() }}",
            fetchToursPath: '{{ config('learningtour.routes.fetch_path') }}',
            updateStepPath: '{{ config('learningtour.routes.update_path') }}',
            completeTourPath: '{{ config('learningtour.routes.complete_path') }}',
            tours: {!! json_encode($learningtours) !!}
        };
        learningTour.init(config);
    });
</script>
