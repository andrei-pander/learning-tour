<?php

Route::controller('tours', 'Majesko\LearningTour\Http\Controllers\TourController', [
	'getList' => 'learningtour::tours.list',
	'getCreate' => 'learningtour::tours.create',
	'getEdit' => 'learningtour::tours.edit',
	'getCreateStep' => 'learningtour::tours.create-step',
	'getEditStep' => 'learningtour::tours.edit-step',
	'postCreate' => 'learningtour::tours.create',
	'postEdit' => 'learningtour::tours.edit',
	'postDelete' => 'learningtour::tours.delete',
	'postCreateStep' => 'learningtour::tours.create-step',
	'postEditStep' => 'learningtour::tours.edit-step',
	'postDeleteStep' => 'learningtour::tours.delete-step'
]);
