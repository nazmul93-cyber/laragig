<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Models\User;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// view 
// all listings 
Route::get('/', [ListingController::class, 'index']);

// listing create 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');       // only auth users can create new posts

// store listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');  

// edit listing 
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');  

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');  

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');  

// manage listing 
Route::get('/listings/manage', [ListingController::class, 'manage'])->name('manage')->middleware('auth');

// single listing - route model binding - if wild card id doesn't match model instance id from db -> abort 404 
Route::get('/listings/{listing}', [ListingController::class, 'show']);






// show registration form 
Route::get('register', [UserController::class, 'create'])->name('register')->middleware('guest'); 
// store user
Route::post('/users', [UserController::class, 'store'])->middleware('guest'); 

// log out user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');  

// login user
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest'); 
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('authenticate')->middleware('guest'); 














// search request 
Route::get('/search', function (Request $request) {       // /search?name=jimmy&city=bd
    // dd($request);       // query parameters 
    // dd($request->name.' '. $request->city);
    return ($request->name . ' ' . $request->city);
});

// wild card 
Route::get('/posts/{id}', function ($id) {
    // ddd($id);
    dd($id);        // dump and die / give 500 error in network
    return response("post $id");
})->where('id', '[0-9]+');               // constraints ;






// route network options
Route::get('hello', function () {
    return response("<h1> Hello World </h1>", 404)             // default response status 200 
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar');
});

// Route::get('hello', function () {
//     return "Hello World";
// });