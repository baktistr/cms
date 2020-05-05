<?php

use App\Province;
use App\Regency;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csv', function () {
    $path = database_path('seeds\locations\districs.csv');
        $data = file($path);
        $newData = array();
        foreach ($data as $row) {
            $explode = explode(',', $row);
            $newData[] = $explode;
        }
        collect($newData)
            ->each(function ($pro) {
                factory(Regency::class)->create([
                    'id' => $pro[0],
                    'province_id' => $pro[1],
                    'name' => $pro[2]
                ]);
            });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
