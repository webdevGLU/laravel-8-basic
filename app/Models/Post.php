<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all()
    {
        $files =  File::files(resource_path("posts/"));

        return array_map(function ($file){
            $file->getContents();
        }, $files);
    }

    public static function find($slug)
    {
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
    
        return cache()->remember("posts.{$slug}", 5, fn() => file_get_contents($path));
    }
}