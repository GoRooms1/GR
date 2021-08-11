<?php

namespace App\Http\Controllers;

use League\Glide\ServerFactory;

class ImageController extends Controller
{

  public function show($path): void
  {
    $server = ServerFactory::create([
      'source' => 'storage',
      'cache' => 'storage',
      'cache_path_prefix' => '.cache',
    ]);
    $server->outputImage($path, request()->all());
  }
}
