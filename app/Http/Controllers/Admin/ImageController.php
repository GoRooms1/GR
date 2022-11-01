<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\Image\Traits\UploadImage;

class ImageController extends Controller
{
    use UploadImage;
}
