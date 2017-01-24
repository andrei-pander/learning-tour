<?php

namespace Majesko\LearningTour\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Majesko\LearningTour\Models\Tour;
use Majesko\LearningTour\Models\TourStatus;

class LearningTourMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ( ! $request->isMethod('get')) {
			return $next($request);
		}

		$result = [];

		$route_action_name = class_basename($request->route()->getActionName());


		/** @var Tour[]|Collection $tours */
		$tours = Tour::query()
			->with([
				'steps' => function ($query) use ($route_action_name) {
					$query->orderBy('order', 'asc')
						->where('active', 1)
						->where('route', $route_action_name);
				}])
			->where('active', 1)
			->get();

		foreach ($tours as $key => $tour) {
			$result[$key] = [$tour->tour_code =>
				[
					'id' => $tour->tour_code,
					'name' => $tour->name,
					'steps' => $tour->steps,
					'step' => 0,
					'base_id' => $tour->id,
					'completed' => 0
				]];

			/** @var TourStatus $status */
			$status = TourStatus::getUncompleted(Auth::user(), $tour->id);

			if ($status) {
				/*
				 * If tour step in active state set it, else get first next active step
				 * */
				if ($tour->steps->contains('id', $status->step_id)) {
					foreach ($tour->steps as $num => $step) {
						if ($step->id == $status->step_id) {
							$result[$key][$tour->tour_code]['step'] = $num;
						}
					}
				}
				else {
					$nextStep = $tour->steps->filter(function ($item) use ($status) {
						return $item->id > $status->step_id;
					})->first();
					if ( ! $nextStep) {
						$status->completeTour(Auth::user());
					}
					else {
						foreach ($tour->steps as $num => $step) {
							if ($step->id == $nextStep->id) {
								$result[$key][$tour->tour_code]['step'] = $num;
							}
						}
					}
				}
			}

			/*
			 * If tour already completed by user, mark it as completed
			 */
			if (TourStatus::query()
				->where('user_id', Auth::id())
				->where('tour_id', $tour->id)
				->whereNotNull('completed_at')
				->count()
			) {
				$result[$key][$tour->tour_code]['completed'] = 1;
			}
		}

		view()->share('learningtours', $result);

		return $next($request);
	}
}
