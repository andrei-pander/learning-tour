<?php

namespace Majesko\LearningTour\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Majesko\LearningTour\Models\TourStatus;
use Majesko\LearningTour\Models\TourStep;
use Majesko\LearningTour\Models\Tour;

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

		return Response::json('');
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

		if( ! $status) {
			(new TourStatus())->createStatus(Auth::user(), $tour, $step_id);
		}
		else {
			$status->updateStatus($step_id);
		}

		return Response::json();
	}

	public function getList() {

		$tours = Tour::with(['steps' => function($query) {
			$query->orderBy('order', 'asc');
		}])->get();

		return View::make('learningtour::list', ['tours' => $tours]);
	}

	public function getCreate() {
		return View::make('learningtour::edit');
	}

	public function postCreate(Request $request) {
		$tour = new Tour;

		if( ! $tour->validate($request)) {
			return Redirect::back()->withErrors($tour->errors())->withInput();
		}

		$tour->tour_code = $request->get('tour_code');
		$tour->name = $request->get('name');
		$tour->active = $request->get('active');
		$tour->save();

		return Redirect::route('learningtour::tours.list')->with('status', trans('learningtour::admin.tour.created'));
	}

	public function getEdit($id) {
		$tour = Tour::findOrFail($id);

		return View::make('learningtour::edit', ['tour' => $tour]);
	}

	public function postDelete($id) {
		$tour = Tour::findOrFail($id);
		$tour->delete();

		return Redirect::back()->with('status', trans('learningtour::admin.tour.deleted'));
	}

	public function postEdit(Request $request, $id) {
		$tour = Tour::findOrFail($id);

		if( ! $tour->validate($request)) {
			return Redirect::back()->withErrors($tour->errors())->withInput();
		}

		$tour->name = $request->get('name');
		$tour->tour_code = $request->get('tour_code');
		$tour->active = $request->get('active');
		$tour->autostart = $request->get('autostart');
		$tour->save();

		return Redirect::route('learningtour::tours.list')->with('status', trans('learningtour::admin.tour.updated'));
	}

	public function getCreateStep($tour_id) {
		$tour = Tour::findOrFail($tour_id);

		return View::make('learningtour::edit-step', ['tour' => $tour]);
	}

	public function postCreateStep(Request $request) {
		$tour = Tour::findOrFail($request->get('tour_id'));
		$step = new TourStep();

		if( ! $step->validate($request)) {
			return Redirect::back()->withErrors($step->errors())->withInput();
		}

		$step->title = $request->get('title');
		$step->content = $request->get('content');
		$step->target = $request->get('target');
		$step->placement = $request->get('placement');
		$step->show_close_button = $request->get('show_close_button');
		$step->show_prev_button = $request->get('show_prev_button');
		$step->show_next_button = $request->get('show_next_button');
		$step->active = $request->get('active');
		$step->order = $request->get('order');
		$step->route = $request->get('route');
		$tour->steps()->save($step);

		return Redirect::route('learningtour::tours.list')->with('status', trans('learningtour::admin.step.created'));
	}

	public function getEditStep($id) {
		$step = TourStep::findOrFail($id);

		return view('learningtour::list-steps', ['step' => $step]);
	}

	public function postEditStep(Request $request, $id) {
		$step = TourStep::findOrFail($id);

		if( ! $step->validate($request)) {
			return Redirect::back()->withErrors($step->errors());
		}

		$step->title = $request->get('title');
		$step->content = $request->get('content');
		$step->target = $request->get('target');
		$step->placement = $request->get('placement');
		$step->show_close_button = $request->get('show_close_button');
		$step->show_prev_button = $request->get('show_prev_button');
		$step->show_next_button = $request->get('show_next_button');
		$step->active = $request->get('active');
		$step->order = $request->get('order');
		$step->route = $request->get('route');
		$step->save();

		return Redirect::route('learningtour::tours.list')->with('status', trans('learningtour::admin.step.updated'));
	}

	public function postDeleteStep($id) {
		$step = TourStep::findOrFail($id);
		$step->delete();

		return Redirect::back()->with('status', trans('learningtour::admin.step.deleted'));
	}
}
