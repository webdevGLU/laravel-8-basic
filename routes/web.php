<?php

use App\Models\Post;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('posts');
});

Route::get('post/{post}', function ($slug) {
    // base_path();
    // app_path();
    // resource_path();
    $path = resource_path("posts/{$slug}.html");

    if (! file_exists($path)) {
        throw new ModelNotFoundException();
        //ddd('file does not exist');
        // return redirect('/');
        //abort(404);
    }

    $post =  cache()->remember("posts.{$slug}", 5, fn() => file_get_contents($path));

    return view('post', [
        'post' => $post 
    ]);
})->where('post','[A-z_\-]+');//regular expression

//->whereAlpha('post'); // alleen Hoofdletters en kleine letters
//->whereAlphaNumeric('post'); //alle letters + cijfers
//->whereNumber('post'); //alleeen cijfers


