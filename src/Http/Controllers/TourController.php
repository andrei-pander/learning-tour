<?php

namespace Majesko\LearningTour\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Majesko\LearningTour\Models\TourStatus;
use Majesko\LearningTour\Models\TourStep;
use Majesko\LearningTour\Models\Tour;
use Illuminate\Support\Facades\View;

class TourController extends Controller
{
	/**
	 * Saves tour status as completed. Invoked when user clicked done button on last step tour.
	 *
	 * @param integer $tour_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postComplete($tour_id) {
		$status = TourStatus::getUncompleted(Auth::user(), $tour_id);
		$status->completeTour();

		return response('');
	}

	/**
	 * Saves step for current running tour. Invoked when new step was opened for current user.
	 *
	 * @param integer $step_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postUpdateStep($step_id) {
		$step = TourStep::findOrFail($step_id);
		$tour = $step->tour;

		$status = TourStatus::getUncompleted(Auth::user(), $tour->id);

		if ( ! $status) {
			(new TourStatus())->createStatus(Auth::user(), $tour, $step_id);
		}
		else {
			$status->updateStatus($step_id);
		}

		return response('');
	}

	/**
	 * Displays list of tours
	 *
	 * @return View
	 */
	public function getList() {

		$tours = Tour::with('steps')->get();

		return view('learningtour::list', ['tours' => $tours]);
	}

	public function getEdit($id) {
		$tour = Tour::find($id);

		return view('learningtour::edit', ['tour' => $tour]);
	}

	public function postEdit(Request $request, $id) {
		$tour = Tour::find($id);
		$tour->name = $request->get('name');
		$tour->tour_code = $request->get('tour_code');
		$tour->save();
		return redirect()->back();
	}
}
