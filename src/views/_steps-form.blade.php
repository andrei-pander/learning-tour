<h1>Step @if(isset($step)) edit @else create @endif</h1>
<form class="form" method="post" action="
		@if(isset($step))
{{ route('learningtour::tours.edit-step', $step->id) }}
@else
{{ route('learningtour::tours.create-step') }}
@endif
	">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="tour_id" class="control-label">Tour</label>
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
		<label for="title" class="control-label">Step title</label><br>
		<input class="form-control" type="text" name="title"
			value="{{ isset($step) ? $step->title : old('title') }}">
		<span class="help-block">{{ $errors->first('title') }}</span>
	</div>

	<div class="form-group @if($errors->has('content')) has-error @endif">
		<label for="content" class="control-label">Content</label><br>
		<textarea class="form-control" name="content">{{ isset($step) ? $step->content : old('content') }}</textarea>
		<span class="help-block">{{ $errors->first('content') }}</span>
	</div>

	<div class="form-group">
		<label for="position">Placement</label>
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
		<label for="target" class="control-label">Target</label>
		<input type="text" class="form-control" name="target"
			value="{{ isset($step) ? $step->target : old('target') }}">
		<span class="help-block">{{ $errors->first('target') }}</span>
	</div>

	<div class="form-group @if($errors->has('order')) has-error @endif">
		<label for="order" class="control-label">Order</label>
		<input type="number" class="form-control" name="order"
			value="{{ isset($step) ? $step->order : old('order') }}">
		<span class="help-block">{{ $errors->first('order') }}</span>
	</div>

	<div class="row">
		<div class="col-lg-3">
			<div class="form-group">
				<label for="show_close_button">Show close</label>
				<input type="hidden" name="show_close_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_close_button" value="1"
					@if(isset($step) && $step->show_close_button || old('show_close_button')) checked @endif>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label for="show_close_button">Show prev</label>
				<input type="hidden" name="show_prev_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_prev_button" value="1"
					@if(isset($step) && $step->show_prev_button || old('show_prev_button')) checked @endif>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label for="show_close_button">Show next</label>
				<input type="hidden" name="show_next_button" value="0"> {{-- dirty hack on null --}}
				<input type="checkbox" name="show_next_button" value="1"
					@if(isset($step) && $step->show_next_button || old('show_next_button')) checked @endif>
			</div>
		</div>

		<div class="form-group">
			<label for="active">Active</label>
			<input type="hidden" name="active" value="0">
			<input type="checkbox" name="active" value="1" @if(isset($step) && $step->active || old('active')) checked @endif>
		</div>
	</div>

	<div class="form-group">
		<label for="route">Route</label>
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
	<button type="submit" class="btn btn-primary">Save</button>
	<a href="{{ route('learningtour::tours.list') }}" class="btn btn-default">Back</a>
</form>
