<?php

declare(strict_types=1);

namespace Domain\Image\Actions;

use Domain\AdBanner\Models\AdBanner;
use Domain\Article\Models\Article;
use Domain\Hotel\Models\Hotel;
use Domain\Media\DataTransferObjects\MediaImageData;
use Domain\Room\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

/**
 * @method static CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection|array run(Request $request, Hotel|Room|Article|AdBanner $uploadTo, string $attr_name = 'image')
 */
final class UploadImageAction extends Action
{
    /**
     * @param  Request  $request
     * @param  Hotel|Room|Article|AdBanner  $uploadTo
     * @param  string  $attr_name
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection|array
     */
    public function handle(Request $request, Hotel|Room|Article|AdBanner $uploadTo, string $attr_name = 'image'): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection|array
    {
        if (! $request->hasFile($attr_name)) {
            return [];
        }

        $files = $request->file($attr_name);
        if (! is_array($files)) {
            $files = [$files];
        }
        
        $images = [];
        $uploadTo
            ->addAllMediaFromRequest()            
            ->each(function (FileAdder $fileAdder)use (&$images){
                $images[] = $fileAdder                    
                    ->withCustomProperties(['moderate' => ! (Auth::user()?->is_moderate || Auth::user()?->is_admin)])
                    ->toMediaCollection('images');               
            });

        return MediaImageData::collection($images);
    }
}
