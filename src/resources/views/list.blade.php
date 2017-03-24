@extends('learningtour::layout')

@section('content')
	<table class="table table-condensed table-bordered">
		<h1>{{ trans('learningtour::admin.tour.list') }} <span class="small"><a href="{{ route('learningtour::tours.create') }}">+ {{ trans('learningtour::admin.tour.add') }}</a></span></h1>
		@foreach($tours as $tour)
			<tbody class="tour-block">
				<tr>
					<td>{{ $tour->name }}</td>
					<td width="10%">
						<a href="{{ route('learningtour::tours.edit', $tour->id) }}" class="btn btn-xs btn-link">{{ trans('learningtour::admin.edit') }}</a>
					</td>
					<td width="5%"><a href="#" class="tour-details-open"><i class="glyphicon glyphicon-menu-down"></i></a></td>
				</tr>
				<tr class="tour-details hidden">
					<td colspan="3">
						<a href="{{ route('learningtour::tours.create-step', $tour->id) }}" class="pull-right">+ {{ trans('learningtour::admin.step.add') }}</a>
						<table class="table table-condensed table-bordered">
							@foreach($tour->steps as $step)
								<tr>
									<td>{{ $step->title }}</td>
									<td>{{ $step->order }}</td>
									<td width="25%">
										<form action="{{ route('learningtour::tours.delete-step', $step->id) }}" class="submit-delete" method="post">
											{{ csrf_field() }}
											<div class="btn-group text-center">
												<a href="{{ route('learningtour::tours.edit-step', $step->id) }}" class="btn btn-xs btn-link">{{ trans('learningtour::admin.edit') }}</a>
												<button type="submit" class="btn btn-xs btn-link"><span class="text-danger">{{ trans('learningtour::admin.delete') }}</span></button>
											</div>
										</form>
									</td>
								</tr>
							@endforeach
						</table>
						<form action="{{ route('learningtour::tours.delete', $step->id) }}" class="submit-delete" method="post">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-link pull-right"><span class="text-danger">x {{ trans('learningtour::admin.delete') }}</span></button>
						</form>
					</td>
				</tr>
			</tbody>
		@endforeach
	</table>
@endsection
