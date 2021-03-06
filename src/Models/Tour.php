<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;

/**
 * @property int id
 * @property string tour_code
 * @property string name
 * @property bool active
 * @property bool autostart
 * @property string triggers
 *
 * @property TourStep[]|Collection steps
 * @see Tour::steps()
 */
class Tour extends BaseModel {
	protected $visible = [
		'tour_code', 'name', 'active', 'triggers', 'autostart'
	];

	protected function rules() {
		return [
			'tour_code' => 'required|unique:tours,tour_code,'.$this->id,
			'name' => 'required'
		];
	}

	public function steps() {
		return $this->hasMany(TourStep::class);
	}
}
