<?php

namespace Majesko\LearningTour\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Majesko\LearningTour\Models\Tour;
use Majesko\LearningTour\Models\TourStep;

class TourController extends Controller
{
	/**
	 * Saves tour status as completed. Invoked when user clicked done button on last step tour.
	 *
	 * @param integer $tour_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postComplete($tour_id) {
		/** @var Tour $tour */
		$tour = Tour::query()->findOrFail($tour_id);
		$tour->completeTour(Auth::user());

		return response('');
	}

	/**
	 * Saves step for current running tour. Invoked when new step was opened for current user.
	 *
	 * @param integer $step_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postSaveStep($step_id) {
		$step = TourStep::oneChild($step_id);
		$step->setCurrent(Auth::user());

		return response('');
	}
}
