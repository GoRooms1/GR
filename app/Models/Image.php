<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use CreatedAtOrdered;

    public const DEFAULT = 'img/img-hotel.jpg';

    protected static $orderDirection = 'ASC';

    protected $fillable = [
        'name',
        'path',
        'default',
    ];

    public static function upload($request, &$uploadTo, $attr_name = 'image')
    {
        if ($request->hasFile($attr_name)) {
            $files = $request->file($attr_name);
            if (!is_array($files)) {
                $files = [$files];
            }
            $images = [];
            $is_default = true;
            if ($uploadTo->image()->count())
                $is_default = false;
            foreach ($files AS $file) {
                $path = $file->store(date('Y/m/d'));
                $image = Image::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => 'storage/' . $path,
                    'default' => $is_default,
                ]);
                $images[] = $image;
                // self::watermark($uploadTo, $image);
                $is_default = false;
            }
            $uploadTo->images()->saveMany($images);
            $uploadTo->save();
            return $images;
        }
        return [];
    }

    public static function watermark($model, Image $image): void
    {
        if (!($model instanceof Hotel || $model instanceof Room))
            return;

        $path = str_replace('storage', 'app/public', $image->path);
        $img = \Intervention\Image\Facades\Image::make(storage_path($path));
        $img->insert(storage_path('images/watermark.png'), 'center');
        $img->save($image->path);
    }

    public static function beforeSave(Image $image)
    {
        if ($image->default) {
            $model_id = $image->model_id;
            $model_type = $image->model_type;

            Image::where('model_id', $model_id)->where('model_type', $model_type)->update(['default' => false]);
        }
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function (Image $image) {
            self::beforeSave($image);
        });

        self::creating(function (Image $image) {
            self::beforeSave($image);
        });

        self::saving(function (Image $image) {
            self::beforeSave($image);
        });

        self::deleting(function (Image $image) {
            if ($image->default) {
                $model_id = $image->model_id;
                $model_type = $image->model_type;
                try {
                    $other_image = Image::where('model_id', $model_id)
                        ->where('model_type', $model_type)
                        ->whereNot('id', $image->id)
                        ->first();
                    $other_image->default = true;
                    $other_image->save();
                } catch (\Exception $exception) {
                    if (Image::where('model_id', $model_id)->where('model_type', $model_type)->count() > 0)
                        Log::error($exception);
                }
            }
            @Storage::delete(str_replace('storage/', '',$image->path));
        });
    }

    /**
     * Меняем урлу картинки на урлу с оптимизацией
     * @param string $value
     * @return string|string[]
     */
    public function getPathAttribute(string $value)
    {
        return str_replace('storage', 'image', $value);
    }
}
