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
			$completedToursCount = TourStatus::countCompleted(Auth::user(), $tour->id);
			$currentStep = 0;



			if($uncompletedTourStatus) {
				$completed = 0;
			}
			else {
				if ($tour->autostart) {
					$completed = $completedToursCount > 0 ? 1 : 0;
				}
				else {
					$completed = 1;
				}
			}

			if ($uncompletedTourStatus) {
				/*
				 * If tour step in active state set it, else get first next active step
				 * */
				if ($tour->steps->contains('id', $uncompletedTourStatus->step_id)) {
					foreach ($tour->steps as $num => $step) {
						if ($step->id == $uncompletedTourStatus->step_id) {
							$currentStep = $num;
						}
					}
				}
				else {
					$nextStep = $tour->steps->filter(function ($item) use ($uncompletedTourStatus) {
						return $item->id > $uncompletedTourStatus->step_id;
					})->first();
					if ( ! $nextStep) {
						$status->completeTour(Auth::user());
					}
					else {
						foreach ($tour->steps as $num => $step) {
							if ($step->id == $nextStep->id) {
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
