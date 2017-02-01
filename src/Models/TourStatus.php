<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int id
 * @property int tour_id
 * @property int user_id
 * @property int step_id
 * @property int step
 * @property string completed_at
 * @property Tour[]|Collection tour
 */
class TourStatus extends Model {
	protected $fillable = ['tour_id', 'user_id', 'step_id', 'step', 'completed_at'];

	public function tour() {
		return $this->belongsTo(Tour::class);
	}

	/**
	 * Creates new initial status;
	 *
	 * @param Model $user
	 * @param Tour $tour
	 * @param string $step_id
	 *
	 * @return bool
	 */
	public function createStatus(Model $user, Tour $tour, $step_id) {
		$status = new TourStatus();
		$status->tour_id = $tour->id;
		$status->user_id = $user->getKey();
		$status->step_id = $step_id;

		return $status->save();
	}

	/**
	 * Updates tour status to next or previous step
	 *
	 * @param $step_id
	 *
	 * @return bool
	 */
	public function updateStatus($step_id) {
		$this->step_id = $step_id;
		$this->save();

		return true;
	}

	/**
	 * Updates tour status as completed
	 *
	 * @return bool
	 */
	public function completeTour() {
		$this->completed_at = Carbon::now();
		$this->save();

		return true;
	}

	/**
	 * Get uncompleted tour status for given user and tour
	 *
	 * @param Model $user
	 * @param int $tour_id
	 *
	 * @return TourStatus
	 */
	public static function getUncompleted(Model $user, $tour_id) {
		return static::query()
			->where('tour_id', $tour_id)
			->where('user_id', $user->getkey())
			->whereNull('completed_at')
			->first();
	}
}
