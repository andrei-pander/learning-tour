<h1>@if(isset($tour)) {{ trans('learningtour::admin.tour.edit') }} @else {{ trans('learningtour::admin.tour.add') }} @endif</h1>
<form class="form" method="post" action="
		@if(isset($tour))
			{{ route('learningtour::tours.update', $tour->id) }}
		@else
			{{ route('learningtour::tours.store') }}
		@endif
	">
	{{ csrf_field() }}
	<div class="form-group @if($errors->has('tour_code')) has-error @endif">
		<label for="tour_code" class="control-label">{{ trans('learningtour::admin.fields.tour.tour-code') }}</label><br>
		<input class="form-control" type="text" name="tour_code" value=
		"{{ isset($tour) ? $tour->tour_code : old('tour_code') }}">
		<span class="help-block">{{ $errors->first('tour_code') }}</span>
	</div>

	<div class="form-group @if($errors->has('name')) has-error @endif">
		<label for="name" class="control-label">{{ trans('learningtour::admin.fields.tour.name') }}</label><br>
		<input class="form-control" type="text" name="name" value=
		"{{ isset($tour) ? $tour->name : old('name') }}">
		<span class="help-block">{{ $errors->first('name') }}</span>
	</div>

	<div class="form-group">
		<label for="active">{{ trans('learningtour::admin.fields.tour.active') }}</label>
		<input type="hidden" name="active" value="0">
		<input type="checkbox" name="active" value="1" @if(isset($tour) && $tour->active || old('active')) checked @endif>
	</div>

	<button type="submit" class="btn btn-primary">{{ trans('learningtour::admin.save') }}</button>
	<a href="{{ route('learningtour::tours.list') }}" class="btn btn-default">{{ trans('learningtour::admin.back') }}</a>
</form>
