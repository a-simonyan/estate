<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
Route::get('/mail', function () {
  dd("mail new update");
  $api_key = env('YANDEX_KEY','5ba341c6-2228-439d-b08c-4bcd1403d6c1');
  $longLat = '44.513028965607,40.164057816139';
  $lang = 'ru-RU';  
  $data =  Http::get('https://geocode-maps.yandex.ru/1.x/?apikey='.$api_key.'&format=json&geocode='.$longLat.'&lang='.$lang.'&results=1');
  $json = json_decode($data->body(), true);
//   dd($json['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted']);
  dd($json['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']);

//   dd($json->response->GeoObjectCollection);
});
// Route::get('/test','TestController@test');
Route::get('/json','TestController@json');

Route::get('login/{provider}', 'TestController@redirect');
Route::get('login/{provider}/callback','TestController@Callback' );

Route::get('/seed', function () {
    // Artisan::call('db:seed');
    dd("work filter land_area");
});
Route::get('/t2', function () {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';    
   
// dd($ipaddress);
    // dd(Session::get('provider'));

    // return view('test2');
    $phones = App\User::find(null);
//     if(in_array(3,$phones)){
// dd(true);
//     } else {
//        dd(false);
//     }

return response()->json(['data'=>$phones ]); 
});