<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
//  public function show(Filesystem $filesystem, $path)
//  {
//    $server = ServerFactory::create([
//      'response' => new LaravelResponseFactory(app('request')),
//      'source' => $filesystem->getDriver(),
//      'cache' => $filesystem->getDriver(),
//      'cache_path_prefix' => '.cache',
//      'base_url' => 'image',
//    ]);
////        $path = str_replace('image', 'storage', $path);
//    return $server->getImageResponse($path, request()->all());
//  }

  public function show($path)
  {
//    $server = ServerFactory::create([
//      'response' => new LaravelResponseFactory(app('request')),
//      'source' => $filesystem->getDriver(),
//      'cache' => $filesystem->getDriver(),
//      'cache_path_prefix' => '.cache',
//      'base_url' => 'image',
//    ]);

    $server = ServerFactory::create([
      'source' => 'storage',
      'cache' => 'storage',
      'cache_path_prefix' => '.cache',
    ]);
//    $path = str_replace('image', 'storage', $path);
    $server->outputImage($path, request()->all());

//        $path = str_replace('image', 'storage', $path);
//    return $server->getImageResponse($path, request()->all());
  }
}
