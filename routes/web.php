<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Input;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Route::get('/', 'PagesController@index');
//Route::get('/', 'PostsController');
Route::get('about', 'PagesController@about');
Route::get('/find', 'UserController@find');
Route::get('/notification', 'PagesController@notification');
//Route::get('/profile', 'PagesController@profile');

//Route::resource('posts', 'PostsController');
Route::resource('', 'PostsController');
Route::resource('/show', 'PostsController');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', 'PostsController@index')->name('home');
    Route::post('user/{user}', 'UserController@viewProfile');
});

Route::any ( '/found-users', 'FindController@user');
Route::any ( '/found-posts', 'FindController@post');
Route::any ( '/found-all', 'FindController@all');

// Route::any ( '/found-users', function () {
//     $q = Input::get ( 'q' );
//     $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'email', 'LIKE', '%' . $q . '%' )->get ();
//     if (count ( $user ) > 0)
//         return view ( 'pages.found-users' )->withDetails ( $user )->withQuery ( $q );
//     else
//         return view ( 'pages.found-users' )->withMessage ( 'No Details found. Try to search again !' );
// } );

// Route::any ( '/found-posts', function () {
//     $q = Input::get ( 'q' );
//     $post = Post::where ( 'title', 'LIKE', '%' . $q . '%' )->orWhere ( 'body', 'LIKE', '%' . $q . '%' )->get ();
//     if (count ( $post ) > 0)
//         return view ( 'pages.found-posts' )->withDetails ( $post )->withQuery ( $q );
//     else
//         return view ( 'pages.found-posts' )->withMessage ( 'No Details found. Try to search again !' );
// } );

//$route->post('user/{profileId}/follow', 'UserController@followUser')->name('user.follow');
//$route->post('/{profileId}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');

//route::post('user/{profileId}/follow', 'UserController@followUser')->name('user.follow');
//route::post('/{profileId}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');

Route::get('/user/{profileId}/follow', ['as' => 'user.follow', 'uses' => 'UserController@followUser']);
Route::get('/user/{profileId}/unfollow', ['as' => 'user.unfollow', 'uses' => 'UserController@unfollowUser']);
Route::get('/user/{profileId}/show', 'UserController@show');
Route::get('/user/{profileId}/edit', 'UserController@edit');

Route::get('user/{profileId}',  ['as' => 'user.edit', 'uses' => 'UserController@edit']);
Route::patch('user/{user}/update',  ['as' => 'user.update', 'uses' => 'UserController@update']);

//Route::post('user/{profileId}/follow', 'UserController@followUser')->name('user.follow');
//Route::post('/{profileId}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');