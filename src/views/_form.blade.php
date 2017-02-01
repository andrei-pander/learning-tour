<h1>Tour @if(isset($tour)) edit @else create @endif</h1>
<form class="form" method="post" action="
		@if(isset($tour))
			{{ url('/tours/edit', $tour->id) }}
		@else
			{{ url('/tours/create') }}
		@endif
	">
	{{ csrf_field() }}
	<div class="form-group @if($errors->has('tour_code')) has-error @endif">
		<label for="tour_code" class="control-label">Tour code</label><br>
		<input class="form-control" type="text" name="tour_code" value=
		"@if(isset($tour)){{ $tour->tour_code }}@endif">
		<span class="help-block">{{ $errors->first('tour_code') }}</span>
	</div>

	<div class="form-group @if($errors->has('name')) has-error @endif">
		<label for="name" class="control-label">Name</label><br>
		<input class="form-control" type="text" name="name" value=
		"@if(isset($tour)){{ $tour->name }}@endif">
		<span class="help-block">{{ $errors->first('name') }}</span>
	</div>

	<button type="submit" class="btn btn-primary">Save</button>
</form>
