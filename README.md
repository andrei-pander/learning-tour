# Learning tour
*Learning tour for  Laravel projects (5.1+), based on Hopscotch learning tour (https://github.com/linkedin/hopscotch)*

## Installation steps
Добавить пакет в composer.json

Выполнить composer update.

`composer update`

Прописать в app.php сервис провайдер.

`Majesko\LearningTour\LearningTourProvider::class,`
 
Экспортировать из пакета миграции и конфигурационный файл.
```
php artisan vendor:publish --tag=migrations
php artisan vendor:publish --tag=config
```
Добавить маршруты, необходимые для работы в routes.php 
```php
Route::post('tours/update-step/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@postUpdateStep');
Route::post('tours/complete/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@postComplete');
```
Прописать соответствующие предыдущему шагу маршруты в конфигурационный файл learningtour.php
```php
'routes' => [
    'update_path' => '/tours/update-step',
    'complete_path' => '/tours/complete'
]
```
Опционально прописать маршруты для панели управления:
```php
Route::group(['prefix' => 'tours'], function () {
    Route::get('list', '\Majesko\LearningTour\Http\Controllers\TourController@getList')->name('learningtour::tours.list');
    Route::get('create', '\Majesko\LearningTour\Http\Controllers\TourController@getCreate')->name('learningtour::tours.create');
    Route::get('edit/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@getEdit')->name('learningtour::tours.edit');
    Route::post('create', '\Majesko\LearningTour\Http\Controllers\TourController@postCreate')->name('learningtour::tours.store');
    Route::post('edit/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@postEdit')->name('learningtour::tours.update');
    Route::post('delete/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@postDelete')->name('learningtour::tours.delete');
    Route::get('create-step/{tour_id}', '\Majesko\LearningTour\Http\Controllers\TourController@getCreateStep')->name('learningtour::tours.create-step');
    Route::get('edit-step/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@getEditStep')->name('learningtour::tours.edit-step');
    Route::post('create-step', '\Majesko\LearningTour\Http\Controllers\TourController@postCreateStep')->name('learningtour::tours.store-step');
    Route::post('edit-step', '\Majesko\LearningTour\Http\Controllers\TourController@postEditStep')->name('learningtour::tours.update-step');
    Route::post('delete-step/{id}', '\Majesko\LearningTour\Http\Controllers\TourController@postDeleteStep')->name('learningtour::tours.delete-step');
});
```
Подключить скрипты и стили (в gulpfile или шаблон)

```
vendor/majesko/learning-tour/src/resources/assets/css/learningtour.css'
vendor/majesko/learning-tour/src/resources/assets/js/learningtour.js'
```

Подключить в шаблон скрипты
```php
@if(isset($learningtours))
    @include('learningtour::scripts', ['deferred' => 'true', 'tours' => $learningtours])
@endif
```

