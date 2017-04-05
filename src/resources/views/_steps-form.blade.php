<h1>@if(isset($step)) {{ trans('learningtour::admin.step.edit') }} @else {{ trans('learningtour::admin.step.add') }} @endif</h1>
<form class="form" method="post" action="
		@if(isset($step))
{{ route('learningtour::tours.update-step', $step->id) }}
@else
{{ route('learningtour::tours.store-step') }}
@endif
	">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="tour_id" class="control-label">{{ trans('learningtour::admin.fields.step.name') }}</label>
		<select name="tour_id" class="form-control">
			@foreach(\Majesko\LearningTour\Models\Tour::all() as $tourItem)
				<option value="{{ $tourItem->id }}"
					@if(isset($step) && $tourItem->id == $step->tour->id
					|| isset($tour) && $tourItem->id == $tour->id
					|| $tourItem->id == old('tour_id'))selected
					@endif
				>{{ $tourItem->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group @if($errors->has('title')) has-error @endif">
		<label for="title" class="control-label">{{ trans('learningtour::admin.fields.step.title') }}</label><br>
		<input class="form-control" type="text" name="title"
			value="{{ isset($step) ? $step->title : old('title') }}">
		<span class="help-block">{{ $errors->first('title') }}</span>
	</div>

	<div class="form-group @if($errors->has('content')) has-error @endif">
		<label for="content" class="control-label">{{ trans('learningtour::admin.fields.step.content') }}</label><br>
		<textarea class="form-control" name="content">{{ isset($step) ? $step->content : old('content') }}</textarea>
		<span class="help-block">{{ $errors->first('content') }}</span>
	</div>

	<div class="form-group">
		<label for="position">{{ trans('learningtour::admin.fields.step.placement') }}</label>
		<select name="placement" id="" class="form-control">
			@foreach(['top', 'bottom', 'left', 'right'] as $positionItem)
				<option value="{{ $positionItem }}"
					@if(isset($step) && $positionItem == $step->placement
						|| $positionItem == old('placement')) selected @endif>
					{{ $positionItem }}
				</option>
			@endforeach
		</select>
	</div>

	<div class="form-group @if($errors->has('target')) has-error @endif">
		<label for="target" class="control-label">{{ trans('learningtour::admin.fields.step.target') }}</label>
		<input type="text" class="form-control" name="target"
			value="{{ isset($step) ? $step->target : old('target') }}">
		<span class="help-block">{{ $errors->first('target') }}</span>
	</div>

	<div class="form-group @if($errors->has('order')) has-error @endif">
		<label for="order" class="control-label">{{ trans('learningtour::admin.fields.step.order') }}</label>
		<input type="number" class="form-control" name="order"
			value="{{ isset($step) ? $step->order : old('order') }}">
		<span class="help-block">{{ $errors->first('order') }}</span>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="form-group">
				<label for="show_close_button">{{ trans('learningtour::admin.fields.step.show-close') }}</label>
				<input type="hidden" name="show_close_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_close_button" value="1"
					@if(isset($step) && $step->show_close_button || old('show_close_button')) checked @endif>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label for="show_close_button">{{ trans('learningtour::admin.fields.step.show-prev') }}</label>
				<input type="hidden" name="show_prev_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_prev_button" value="1"
					@if(isset($step) && $step->show_prev_button || old('show_prev_button')) checked @endif>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label for="show_close_button">{{ trans('learningtour::admin.fields.step.show-next') }}</label>
				<input type="hidden" name="show_next_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_next_button" value="1"
					@if(isset($step) && $step->show_next_button || old('show_next_button')) checked @endif>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="form-group">
				<label for="active">{{ trans('learningtour::admin.fields.step.active') }}</label>
				<input type="hidden" name="active" value="0">
				<input type="checkbox" name="active" value="1" @if(isset($step) && $step->active || old('active')) checked @endif>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="form-group">
				<label for="active">{{ trans('learningtour::admin.fields.step.multipage') }}</label>
				<input type="hidden" name="multipage" value="0">
				<input type="checkbox" name="multipage" value="1" @if(isset($step) && $step->active || old('multipage')) checked @endif>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="form-group">
				<label for="active">{{ trans('learningtour::admin.fields.step.next_on_target_click') }}</label>
				<input type="hidden" name="next_on_target_click" value="0">
				<input type="checkbox" name="next_on_target_click" value="1" @if(isset($step) && $step->next_on_target_click || old('next_on_target_click')) checked @endif>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="route">{{ trans('learningtour::admin.fields.step.route') }}</label>
		<select class="form-control" name="route" id="">
			@foreach (\Illuminate\Support\Facades\Route::getRoutes() as $routeItem)
				<option
					@if(isset($step) && $step->route == $routeItem->getActionName() || $routeItem == old('route'))
						selected
					@endif
					value="{{ $routeItem->getActionName() }}">{{ class_basename($routeItem->getActionName()) }}
				</option>
			@endforeach
		</select>
	</div>
	<button type="submit" class="btn btn-primary">{{ trans('learningtour::admin.save') }}</button>
	<a href="{{ route('learningtour::tours.list') }}" class="btn btn-default">{{ trans('learningtour::admin.back') }}</a>
</form>
