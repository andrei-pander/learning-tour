@extends('learningtour::layout')

@section('content')
	<table class="table table-condensed table-bordered">
		<h1>Tours list <span class="small"><a href="{{ url('/tours/create') }}">+ add tour</a></span></h1>
		@foreach($tours as $tour)
			<tbody class="tour-block">
				<tr>
					<td>{{ $tour->name }}</td>
					<td width="10%">
						<a href="{{ url('/tours/edit', $tour->id) }}" class="btn btn-xs btn-link">Edit</a>
					</td>
					<td width="5%"><a href="#" class="tour-details-open"><i class="glyphicon glyphicon-menu-down"></i></a></td>
				</tr>
				<tr class="tour-details hidden">
					<td colspan="3">
						<a href="{{ url('/tours/create-step', $tour->id) }}" class="pull-right">+ add step</a>
						<table class="table table-condensed table-bordered">
							@foreach($tour->steps as $step)
								<tr>
									<td>{{ $step->title }}</td>
									<td>{{ $step->order }}</td>
									<td width="18%">
										<form action="{{ url('/tours/delete-step', $step->id) }}" class="submit-delete" method="post">
											{{ csrf_field() }}
											<div class="btn-group text-center">
												<a href="{{ url('/tours/edit-step', $step->id) }}" class="btn btn-xs btn-link">Edit</a>
												<button type="submit" class="btn btn-xs btn-link"><span class="text-danger">Delete</span></button>
											</div>
										</form>
									</td>
								</tr>
							@endforeach
						</table>
						<form action="{{ url('/tours/delete', $tour->id) }}" class="submit-delete" method="post">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-link pull-right"><span class="text-danger">x delete</span></button>
						</form>
					</td>
				</tr>
			</tbody>
		@endforeach
	</table>
@endsection
