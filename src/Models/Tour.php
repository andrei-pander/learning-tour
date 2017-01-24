<?php

namespace Majesko\LearningTour\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int id
 * @property string tour_code
 * @property string name
 * @property string triggers
 *
 * @property TourStep[]|Collection steps
 * @see Tour::steps()
 *
 * @property Status[]|Collection statuses
 * @see Tour::statuses()
 *
 * @property Status[]|Collection uncompleted
 * @see Tour::uncompleted()
 */
class Tour extends Model
{
	protected $visible = [
		'tour_code', 'name', 'triggers'
	];

	public function statuses() {
		return $this->hasMany(TourStatus::class);
	}

	public function steps() {
		return $this->hasMany(TourStep::class);
	}

	public function uncompleted() {
		return $this->statuses()->whereNull('completed_at');
	}

	/**
	 * @param Model $user
	 *
	 * @return bool
	 */
	public function completeTour(Model $user) {
		$tourStatus = new TourStatus();

		$tourStatus = $tourStatus->oneUncompleted($user, $this);
		$tourStatus->completed_at = Carbon::now();
		$tourStatus->save();

		return true;
	}
}
