<h1>Tour @if(isset($tour)) edit @else create @endif</h1>
<form class="form" method="post" action="
		@if(isset($tour))
			{{ route('learningtour::tours.edit', $tour->id) }}
		@else
			{{ route('learningtour::tours.create') }}
		@endif
	">
	{{ csrf_field() }}
	<div class="form-group @if($errors->has('tour_code')) has-error @endif">
		<label for="tour_code" class="control-label">Tour code</label><br>
		<input class="form-control" type="text" name="tour_code" value=
		"{{ isset($tour) ? $tour->tour_code : old('tour_code') }}">
		<span class="help-block">{{ $errors->first('tour_code') }}</span>
	</div>

	<div class="form-group @if($errors->has('name')) has-error @endif">
		<label for="name" class="control-label">Name</label><br>
		<input class="form-control" type="text" name="name" value=
		"{{ isset($tour) ? $tour->name : old('name') }}">
		<span class="help-block">{{ $errors->first('name') }}</span>
	</div>

	<div class="form-group">
		<label for="active">Active</label>
		<input type="hidden" name="active" value="0">
		<input type="checkbox" name="active" value="1" @if(isset($tour) && $tour->active || old('active')) checked @endif>
	</div>

	<button type="submit" class="btn btn-primary">Save</button>
	<a href="{{ route('learningtour::tours.list') }}" class="btn btn-default">Back</a>
</form>
