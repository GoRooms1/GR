<?php

declare(strict_types=1);

namespace Domain\Image\Actions;

use App\Models\Article;
use App\Parents\Model;
use Domain\Hotel\Models\Hotel;
use Domain\Image\Models\Image;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

/**
 * @method static Image[] run(Request $request, Model $uploadTo, string $attr_name = 'image')
 */
final class UploadImageAction extends Action
{
    /**
     * @param  Request  $request
     * @param  Hotel|Room|Article  $uploadTo
     * @param  string  $attr_name
     * @return Image[]
     */
    public function handle(Request $request, Hotel|Room|Article $uploadTo, string $attr_name = 'image'): array
    {
        if (! $request->hasFile($attr_name)) {
            return [];
        }

        $files = $request->file($attr_name);
        if (! is_array($files)) {
            $files = [$files];
        }
        $images = [];
        if ($uploadTo->images()->count() === 0) {
            $order = 1;
        } else {
            /** @var Collection<Image> $imagesCollection */
            $imagesCollection = $uploadTo->images;
            /** @var Image $lastImage */
            $lastImage = $imagesCollection->last();
            $order = $lastImage->order + 1;
        }
        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $path = $file->store(date('Y/m/d'));
            $image = new Image();
            $image->name = $file->getClientOriginalName();
            $image->path = 'storage/'.$path;
            $image->moderate = ! (Auth::user()?->is_moderate || Auth::user()?->is_admin);
            $image->order = $order;
            $image->save();
            $images[] = $image;
            $order++;
        }
        $uploadTo->images()->saveMany($images);
        $uploadTo->save();

        return $images;
    }
}
