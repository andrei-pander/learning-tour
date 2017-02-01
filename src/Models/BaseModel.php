<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class BaseModel extends Model
{
	protected $errors;

	abstract protected function rules();

	public function validate(Request $request) {
		$v = Validator::make($request->all(), $this->rules());

		if($v->fails()) {
			$this->errors = $v->errors();
			return false;
		}
	}

	public function errors() {
		return $this->errors;
	}

}
