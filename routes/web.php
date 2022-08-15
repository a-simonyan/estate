<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Property;

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
    dd("fix user update");
    $date = Carbon::now()->subYear()->format('Y-m-d');
//    $properties = Property::whereNull('deleted_at')
//        ->whereNull('archived_at')
//        ->whereNull('saved_at')
//        ->whereDate('last_update', '>=', $date)
//        ->update(['archived_at' => Carbon::now()]);

//    dd($properties);
});
Route::get('/changetype', function () {

    Property::where('is_delete', true)->update(['deleted_at'=>Carbon::now()]);
    Property::where('is_archive', true)->update(['archived_at'=>Carbon::now()]);
    Property::where('is_save', true)->update(['saved_at'=>Carbon::now()]);
    dd('update deleted_at, archived_at,  saved_at, 120');
});

// Route::get('/test','TestController@test');
Route::get('/json','TestController@json');

Route::get('login/{provider}', 'TestController@redirect');
Route::get('login/{provider}/callback','TestController@Callback' );

Route::get('/seed', function () {
    //  Artisan::call('db:seed');
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