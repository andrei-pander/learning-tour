<?php

namespace Majesko\LearningTour\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

		$route_action_name = $request->route()->getActionName();

		/** @var Tour[]|Collection $tours */
		$tours = Tour::query()
			->with(['steps' => function($query) {
				$query->orderBy('order', 'asc');
			}])
			->whereHas('steps', function ($query) use ($route_action_name) {
				$query->where('active', 1)
					->where('route', $route_action_name);
			})
			->where('active', 1)
			->get();

		foreach ($tours as $key => $tour) {
			/** @var TourStatus $status */
			$uncompletedTourStatus = TourStatus::getUncompleted(Auth::user(), $tour->id);
			$completed_tours_count = TourStatus::countCompleted(Auth::user(), $tour->id);
			$currentStep = 0;

			if ($uncompletedTourStatus || $tour->autostart && ! $completed_tours_count) {
				$completed = 0;
			}
			else {
				$completed = 1;
			}

			if ($uncompletedTourStatus) {
				/*
				 * If tour step in active state set it, else get first next active step
				 * */
				if ($tour->steps->contains('id', $uncompletedTourStatus->step_id)) {
					foreach ($tour->steps as $num => $step) {
						if ($step->order == $uncompletedTourStatus->step->order) {
							$currentStep = $num;
						}
					}
				}
				else {
					$nextStep = $tour->steps->filter(function ($item) use ($uncompletedTourStatus) {
						return $item->order > $uncompletedTourStatus->step->order;
					})->first();
					if ( ! $nextStep) {
						$status->completeTour(Auth::user());
					}
					else {
						foreach ($tour->steps as $num => $step) {
							if ($step->order == $nextStep->order) {
								$currentStep = $num;
							}
						}
					}
				}
			}

			$result[$key] = [
				$tour->tour_code => [
					'id' => $tour->tour_code,
					'name' => $tour->name,
					'steps' => $tour->steps,
					'step' => $currentStep,
					'base_id' => $tour->id,
					'completed' => $completed,
				]
			];
		}

		view()->share('learningtours', $result);

		return $next($request);
	}
}
