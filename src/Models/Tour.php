<?php

namespace Majesko\LearningTour\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

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
class Tour extends BaseModel
{
	protected $visible = [
		'tour_code', 'name', 'triggers'
	];

	protected function rules() {
		return ['tour_code' => 'required|unique:tours,tour_code,'.$this->tour_code,
		'name' => 'required'];
	}

	public function steps() {
		return $this->hasMany(TourStep::class);
	}
}
