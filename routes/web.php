<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Facades\File;

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
    $files =  File::files(resource_path("posts/"));

    $posts = [];

    foreach ($files as $file) {
        $document = YamlFrontMatter::parseFile($file);

        $posts[] = new Post(
            $document->title,
            $document->excerpt,
            $document->date,
            $document->body,
            $document->slug
        );
    }

    return view('posts',[
        'posts' => $posts
    ]);
});

Route::get('post/{post}', function ($slug) {
    $post = Post::find($slug);

    return view('post', [
        'post' => $post 
    ]);
})->where('post','[A-z_\-]+');//regular expression

//->whereAlpha('post'); // alleen Hoofdletters en kleine letters
//->whereAlphaNumeric('post'); //alle letters + cijfers
//->whereNumber('post'); //alleeen cijfers


