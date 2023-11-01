<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\KongLogs;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    return 'hello world';
});

Route::post('kong_logs/save', function () {

    $post = file_get_contents('php://input');
    $json = $post; //json_encode($post);
    
    if(!$post) {
        $json = json_encode(array("message"=>"none log content"));
    }

    $data = json_decode($json);

    $formdata = [
        "log_detail" => $json,
        "service" => $data->service,
        "request" => $data->request,
        "consumer" => $data->consumer, 
        "upstream_uri" => json_encode($data->upstream_uri, JSON_UNESCAPED_SLASHES),
        "agent_sender" => $_SERVER['HTTP_USER_AGENT'],
        "ip_sender" => \Request::getClientIp(true),
        "create_datetime" => date("Y-m-d H:i:s")
    ];

    $result = KongLogs::create($formdata);

    return $formdata;
});
