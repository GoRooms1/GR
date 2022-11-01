<?php

declare(strict_types=1);

namespace Domain\Image\Actions;

use Domain\Hotel\Models\Hotel;
use Domain\Image\Models\Image;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(Hotel|Room $model, Image $image)
 */
final class AddWatermarkAction extends Action
{
    public function handle(Hotel|Room $model, Image $image): void
    {
        $path = str_replace('storage', 'app/public', $image->path);
        if (is_array($path)) {
            $path = $path[0];
        }
        $img = \Intervention\Image\Facades\Image::make(storage_path($path));
        $img->insert(storage_path('images/watermark.png'), 'center');
        $imagePath = $image->path;
        if (is_array($imagePath)) {
            $imagePath = $imagePath[0];
        }
        $img->save($imagePath);
    }
}
