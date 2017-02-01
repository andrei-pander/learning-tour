<?php

namespace Majesko\LearningTour\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class BaseModel extends Model {
	protected $errors;

	abstract protected function rules();

	public function validate(Request $request) {
		$validation = Validator::make($request->all(), $this->rules());

		if ($validation->fails()) {
			$this->errors = $validation->errors();

			return false;
		}

		return true;
	}

	public function errors() {
		return $this->errors;
	}

}
