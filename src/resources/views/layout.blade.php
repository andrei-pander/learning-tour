<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Tour manager</title>
	<style>
		.hidden {
			display: none;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="col-lg-6">
		@yield('content')
	</div>
	<div class="col-lg-6">
		<hr>
		@if(session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $('document').ready(function () {
        $('.tour-details-open').on('click', function (e) {
            e.preventDefault();
            var el = $(this);
            var parent = el.closest('.tour-block');
            var target = parent.find('.tour-details');
            var chevron = parent.find('i');
            target.toggleClass('hidden');
            if (chevron.hasClass('glyphicon-menu-down')) {
                chevron.removeClass('glyphicon-menu-down');
                chevron.addClass('glyphicon-menu-up');
            } else {
                chevron.removeClass('glyphicon-menu-up');
                chevron.addClass('glyphicon-menu-down');
            }
        });
        $('.submit-delete').on('submit', function (e) {
            if(!confirm('Are you sure?')) {
				return false;
			}
        });
    });
</script>
</body>
</html>
