<?php

namespace Majesko\LearningTour\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

	public function steps() {
		return $this->hasMany(TourStep::class);
	}
}
