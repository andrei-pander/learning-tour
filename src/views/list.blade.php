@extends('learningtour::layout')

@section('content')
	<table class="table table-condensed table-bordered">
		<h1>Tours list <span class="small"><a href="{{ url('/tours/create') }}">+ add tour</a></span></h1>
		@foreach($tours as $tour)
			<tbody class="tour-block">
				<tr>
					<td>{{ $tour->name }}</td>
					<td width="10%">
						<a href="{{ url('/tours/edit', $tour->id) }}">Edit</a>
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
									<td width="10%"><a href="{{ url('/tours/edit-step', $step->id) }}">Edit</a></td>
								</tr>
							@endforeach
						</table>
						<a href="{{ url('/tours/destroy', $tour->id) }}" class="text-danger pull-right">x delete</a>
					</td>
				</tr>
			</tbody>
		@endforeach
	</table>
@endsection
