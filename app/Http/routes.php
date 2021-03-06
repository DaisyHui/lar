<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware'=>'test:male'],function(){
    Route::get('/write/laravelacademy',function(){
        return "write";
    });
    Route::get('/update/laravelacademy',function(){
        return "update";
    });
});

Route::get('/age/refuse',['as'=>'refuse',function(){
    return "18岁以上男子才能访问！";
}]);

Route::resource('post','PostController');

Route::controller('request','RequestController');

// Route::get('testResponseJson',function(){
//     return response()->json(['name'=>'LaravelAcademy','passwd'=>'LaravelAcademy.org']);
// });

Route::get('testResponseJson',function(){
    return response()->json(['name'=>'LaravelAcademy','passwd'=>'LaravelAcademy.org'])
    ->setCallback(request()->input('callback'));
});

Route::get('testResponseDownload',function(){
    return response()->download(
        realpath(base_path('public/images')).'/11.jpg',
        'Laravel.jpg'
    );
});

Route::get('testResponseRedirect',function(){
    return redirect()->action('PostController@show',[1]);
});

Route::resource('test','TestController');

// Blog pages
get('/', function () {
    return redirect('/blog');
});
get('blog', 'BlogController@index');
get('blog/{slug}', 'BlogController@showPost');

// Admin area
get('admin', function () {
    return redirect('/admin/post');
});
$router->group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
    resource('admin/post', 'PostController');
    resource('admin/tag', 'TagController', ['except' => 'show']);
    get('admin/upload', 'UploadController@index');
    post('admin/upload/file', 'UploadController@uploadFile');
    delete('admin/upload/file', 'UploadController@deleteFile');
    post('admin/upload/folder', 'UploadController@createFolder');
    delete('admin/upload/folder', 'UploadController@deleteFolder');
});

// Logging in and out
get('/auth/login', 'Auth\AuthController@getLogin');
post('/auth/login', 'Auth\AuthController@postLogin');
get('/auth/logout', 'Auth\AuthController@getLogout');

