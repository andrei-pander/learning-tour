<h1>Step @if(isset($step)) edit @else create @endif</h1>
<form class="form" method="post" action="
		@if(isset($step))
{{ url('/tours/edit-step', $step->id) }}
@else
{{ url('/tours/create-step') }}
@endif
	">
	{{ csrf_field() }}
	<div class="form-group">
		<select name="" class="form-control">
			@foreach(\Majesko\LearningTour\Models\Tour::all() as $tourItem)
				<option value="{{ $tourItem->id }}"
					@if(isset($step) && $tourItem->id == $step->tour->id
					|| isset($tour) && $tourItem->id == $tour->id)selected
					@endif
				>{{ $tourItem->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label for="tour_code">Tour code</label><br>
		<input class="form-control" type="text" name="title" value=
		"@if(isset($step)){{ $step->title }}@endif">
	</div>

	<div class="form-group">
		<label for="name">Name</label><br>
		<textarea class="form-control" name="content">@if(isset($step)){{ $step->content }}@endif</textarea>
	</div>

	<div class="form-group">
		<label for="position">Placement</label>
		<select name="placement" id="" class="form-control">
			@foreach(['top', 'bottom', 'left', 'right'] as $positionItem)
				<option value="{{ $positionItem }}"
					@if(isset($step) && $positionItem == $step->placement) selected @endif>
					{{ $positionItem }}
				</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label for="target">Target</label>
		<input type="text" class="form-control" value="@if(isset($step)){{ $step->target }}@endif">
	</div>

	<div class="form-group">
		<label for="order">Order</label>
		<input type="number" class="form-control" name="order" value="@if(isset($step)){{ $step->order }}@endif">
	</div>

	<div class="form-group">
		<label for="route">Route</label>
		<select class="form-control" name="route" id="">
			@foreach (\Illuminate\Support\Facades\Route::getRoutes() as $routeItem)
				<option @if(isset($step) && $step->route == class_basename($routeItem->getActionName()))
					selected
					@endif
					value="{{ class_basename($routeItem->getActionName()) }}">{{ class_basename($routeItem->getActionName()) }}</option>
			@endforeach
		</select>
	</div>
	<button type="submit" class="btn btn-primary">Save</button>
</form>
<div class="col-lg-8">

</div>
