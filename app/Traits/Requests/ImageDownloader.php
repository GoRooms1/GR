<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 15.07.2020
 * Time: 21:06
 */

namespace App\Traits\Requests;

use Domain\Image\Models\Image;
use Illuminate\Support\Carbon;

trait ImageDownloader
{
    public function getImageId()
    {
        $image_id = false;
        if ($this->hasFile('image')) {
            $file = $this->file('image');

            $name = $file->getClientOriginalName();

            $date = Carbon::now()->format('Y-m-d');
            $path = $file->store("upload/{$date}", 'public');

            $fileModel = Image::create([
                'path' => $path,
                'name' => $name,
            ]);
            $image_id = $fileModel->id;
        }

        return $image_id;
    }
}
