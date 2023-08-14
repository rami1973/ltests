<?php

use Illuminate\Support\Facades\Route;
use Alkoumi\LaravelHijriDate\Hijri;
use LasePeCo\Geocoder\Facades\Geocoder;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfController;
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
Route::get('graphs',[ PdfController::class,'graphs']);

Route::get('graphs-pdf', [PdfController::class,'graphPdf']);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return view('test');
});
Route::get('file2/{fpath}/{filename}',[FileController::class, 'getFile2'] )->where('filename', '^[^/]+$');
Route::get('file/{filename}',[FileController::class, 'getFile'] )->where('filename', '^[^/]+$');
Route::get('image-upload', [ ImageUploadController::class, 'imageUpload' ])->name('image.upload');
Route::post('image-upload', [ ImageUploadController::class, 'imageUploadPost' ])->name('image.upload.post');
Route::post('fupload', [ ImageUploadController::class, 'fileUploadPost' ])->name('file.upload.post');
Route::get('/geocode/{lat}/{lng}/{lang}', function ($lat,$lng,$lang) {
    $key=env('GOOGLE_MAPS_API_KEY');
    //dd($key);
    $url="https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&language=$lang&key=$key";
  $json = file_get_contents($url);
$obj = json_decode($json);
$results =$obj->results;
if ($results[1]) {
  $country = null;
   $countryCode = null; $city = null; $cityAlt = null;

for ($r=0; $r < count($results); $r++) {
$result = $results[$r];
      if (!$city && $result->types[0] === 'locality') {
          for ($c=0; $c < count($result->address_components); $c++) {

              $component = $result->address_components[$c];

              if ($component->types[0] === 'locality') {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_2") {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_1") {
                  $city = $component->long_name;
                  break;
              }
          }
      }
      else if (!$city && !$cityAlt && $result->types[0] === 'plus_code') {
          for ($c=0; $c < count($result->address_components); $c++) {
              $component = $result->address_components[$c];

              if ($component->types[0] === 'locality') {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_2") {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_1") {
                  $city = $component->long_name;
                  break;
              }
          }
      }else if (!$city && !$cityAlt && $result->types[0] === 'administrative_area_level_2') {
          for ($c=0; $c < count($result->address_components); $c++) {
              $component = $result->address_components[$c];

              if ($component->types[0] === 'locality') {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_2") {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_1") {
                  $city = $component->long_name;
                  break;
              }
          }
      } else if (!$city && !$cityAlt && $result->types[0] === 'administrative_area_level_1') {
          for ($c=0; $c < count($result->address_components); $c++) {
              $component = $result->address_components[$c];

              if ($component->types[0] === 'locality') {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_2") {
                  $city = $component->long_name;
                  break;
              }
              if ($component->types[0] === "administrative_area_level_1") {
                  $city = $component->long_name;
                  break;
              }
          }
      } else if (!$country && $result->types[0] === 'country') {
          $country = $result->address_components[0]->long_name;
          $countryCode = $result->address_components[0]->short_name;
      }

      if ($city && $country) {
          break;
      }
  }

  echo "City: $city   City2:  $cityAlt   Country:  $country   Country Code: $countryCode\n";
}
$ret=[];
$ret['city']=$city;
$ret['country']=$country;
$ret['countryCode']=$countryCode;
echo $ret['city'];

    print_r($obj);
  // $g=app('geocoder')->reverse(43.882587,-103.454067)->get();
 /* $provider = app('geocoder')->getProvider();
$geocoder = new \Geocoder\StatefulGeocoder($provider, $lang);

$g = $geocoder->reverse($lat,$lng)->first();
   $g=app('geocoder')->doNotCache()->reverse($lat,$lng)->get();
   if (count($g) === 0) {
    // empty result
    echo 'e';
  }else{
    echo 'a';

  }
   print_r($g);

    // return view('test');*/
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
