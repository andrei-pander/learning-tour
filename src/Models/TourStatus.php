<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int tour_id
 * @property int user_id
 * @property int step_id
 * @property int step
 * @property string completed_at
 * @property Tour[]|Collection tour
 */
class TourStatus extends Model
{
	protected $fillable = ['tour_id', 'user_id', 'step_id', 'step', 'completed_at'];

	public function tour()
	{
		return $this->belongsTo(Tour::class);
	}

	/**
	 * @param Tour $tour
	 * @param TourStep $step
	 * @param Model $user
	 * @return TourStatus
	 */
	public function createStatus(Tour $tour, TourStep $step, Model $user)
	{
		return TourStatus::create([
			'tour_id' => $tour->id,
			'user_id' => $user->id,
			'step_id' => $step->id
		]);
	}

	/**
	 * @param Tour $tour
	 * @param Model $user
	 * @return TourStatus
	 */
	public function findUncompleted(Tour $tour, Model $user)
	{
		return TourStatus::where('user_id', $user->getKey())
			->where('tour_id', $tour->getKey())
			->whereNull('completed_at')
			->firstOrFail();
	}

	public static function oneUncompleted($user, $tour)
	{
		return self::query()
			->where('user_id', $user->id)
			->where('tour_id', $tour->id)
			->whereNull('completed_at');
	}
}
