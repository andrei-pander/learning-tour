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
        $route_action_name = $request->route()->getActionName();

        /** @var Tour[]|Collection $tours */
        $tours = Tour::query()
            ->with(['steps' => function($query) {
                $query->where('active', 1)
                    ->orderBy('order', 'asc');
            }])
            ->whereHas('steps', function ($query) use ($route_action_name) {
                $query->where('active', 1)
                    ->where('route', $route_action_name);
            })
            ->where('active', 1)
            ->get();

        foreach ($tours as $key => $tour) {
            $uncompletedTourStatus = TourStatus::getUncompleted(Auth::user(), $tour->id);
            $completed_tours_count = TourStatus::countCompleted(Auth::user(), $tour->id);
            $current_step = 0;
            $next_step = 0;

            if ($uncompletedTourStatus || $tour->autostart && ! $completed_tours_count) {
                $completed = 0;
            }
            else {
                $completed = 1;
            }

            if ($uncompletedTourStatus) {
                $current_step = $tour->steps->search(function ($step) use ($uncompletedTourStatus) {
                    return $step->order >= $uncompletedTourStatus->step->order;
                });
                $next_step = $current_step + 1 < count($tour->steps) ? $current_step + 1 : $current_step;
            }


            $result[$key] = [
                $tour->tour_code => [
                    'id' => $tour->tour_code,
                    'name' => $tour->name,
                    'steps' => $tour->steps,
                    'step' => $current_step,
                    'next_step' => $next_step,
                    'base_id' => $tour->id,
                    'completed' => $completed,
                    'current_route' => $route_action_name,
                ]
            ];
        }

        view()->share('learningtours', $result);

        return $next($request);
    }
}
