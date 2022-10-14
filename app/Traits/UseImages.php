<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 17.07.2020
 * Time: 17:49
 */

namespace App\Traits;

use App\Models\Image;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

trait UseImages
{
    public function images(): MorphMany
    {
        /** @var User $user */
        $user = Auth::user();
        if (Auth::guest() || (Auth::check() && ! $user->is_moderate && ! $user->is_admin)) {
            if (! Route::currentRouteNamed('lk.*') &&
              ! Route::currentRouteNamed('moderator.*') &&
              ! Route::currentRouteNamed('api.*') &&
              ! Route::currentRouteNamed('admin.*')) {
                return $this->morphMany(Image::class, 'model')->orderBy('order', 'ASC')->where('moderate', false);
            }
        }

        return $this->morphMany(Image::class, 'model')->orderBy('order', 'ASC');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'model_id', 'id')
          ->where('model_type', '=', self::class)
          ->orderBy('order', 'ASC')
          ->withDefault([
              'path' => $this->no_image ?? Image::DEFAULT,
          ]);
    }

    protected static function bootUseImages()
    {
        self::deleting(function ($model) {
            if ($model->images()->count()) {
                foreach ($model->images as $image) {
                    @Storage::delete(str_replace('storage/', '', $image->path));
                }
                $model->images()->delete();
            }
        });
    }
}
