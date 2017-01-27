<h1>Tour edit</h1>
<form class="form col-lg-4" method="post" action="
		@if(isset($tour))
			{{ url('/tours/edit', $tour->id) }}
		@else
			{{ url('/tours/create') }}
		@endif
	">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="tour_code">Tour code</label><br>
		<input class="form-control" type="text" name="tour_code" value=
		"@if(isset($tour)){{ $tour->tour_code }}@endif">
	</div>

	<div class="form-group">
		<label for="name">Name</label><br>
		<input class="form-control" type="text" name="name" value=
		"@if(isset($tour)){{ $tour->name }}@endif">
	</div>

	<button type="submit" class="btn btn-primary">Save</button>
</form>
