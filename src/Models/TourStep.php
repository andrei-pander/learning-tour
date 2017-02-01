<?php

namespace Majesko\LearningTour\Models;

/**
 * @property int id
 * @property int tour_id
 * @property string title
 * @property string content
 * @property string target
 * @property string placement
 * @property string route
 * @property string order
 * @property string triggers
 */
class TourStep extends BaseModel
{
	protected $visible = ['id', 'target', 'placement', 'title', 'content', 'order', 'position',
		'show_close_button', 'show_prev_button', 'show_next_button', 'next_on_target_click'];

	public function rules()
	{
		return [
			'target' => 'required',
			'title' => 'required',
			'content' => 'required',
			'order' => 'required',
			'route' => 'required'
		];
	}

	public function tour() {
		return $this->belongsTo(Tour::class);
	}
}
