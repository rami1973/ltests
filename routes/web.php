<?php

use Illuminate\Support\Facades\Route;
use Alkoumi\LaravelHijriDate\Hijri;

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
Route::get('/test', function () {
    return view('test');
});
Route::get('/getgreg/{dt}', function ($dt) {
    //http://127.0.0.1:8000/getgreg/25-02-1440
    $day=sprintf("%02d", substr($dt,0,2));
    $month=sprintf("%02d", substr($dt,3,2));
    $year=substr($dt,6,4);
    $dd=Hijri::DateToGregorianFromDMY($day,$month,$year);
    $dd_arr = explode ("/", $dd);
    $gday=sprintf("%02d", $dd_arr[2]);
    $gmonth=sprintf("%02d", $dd_arr[1]);
    $gyear= $dd_arr[0];
    return ("{\"date\":\"$gyear-$gmonth-$gday\"}");
//dd("$day $month $year $dd   $gday  $gmonth $gyear ");
});
