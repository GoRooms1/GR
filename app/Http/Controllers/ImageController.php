<?php

namespace App\Http\Controllers;

use League\Glide\ServerFactory;

class ImageController extends Controller
{

  public function show($path): void
  {
    $server = ServerFactory::create([
      'source' => config('app.glide_path'),
      'cache' => config('app.glide_path'),
      'cache_path_prefix' => '.cache',
    ]);
    $server->outputImage($path, request()->all());
  }
}
