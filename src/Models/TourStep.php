<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Database\Eloquent\Model;

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
class TourStep extends Model
{
	protected $visible = ['id', 'target', 'placement', 'title', 'content',
		'show_close_button', 'show_prev_button', 'show_next_button', 'next_on_target_click'];

	protected $table = 'tour_steps';

	public function tour()
	{
		return $this->belongsTo(Tour::class);
	}

	public static function oneChild($step_id)
	{
		return self::query()
			->where('id', $step_id)
			->where('active', 1)
			->with(['tour' => function($query) {
				$query->where('active', 1);
			}])
			->firstOrFail();
	}

	public function setCurrent($user)
	{
		$status = TourStatus::oneUncompleted($user, $this->tour)
			->firstOrNew([
				'user_id' => $user->id,
				'tour_id' => $this->tour->id,
			]);
		$status->step_id = $this->id;

		return $status->save();
	}
}
