<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Room extends Model
{
    use SoftDeletes;
    use UseImages;
    use CreatedAtOrdered;

    const PER_PAGE = 6;

    public $no_image = 'img/img-room-sm-1.jpg';

    protected $with = [
        'attrs',
        'images',
        'costs',
    ];

  ### SCOPES

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope('moderation', function (Builder $builder) {
      if (auth()->check()) {
        if (!auth()->user()->is_admin && !auth()->user()->is_moderate) {
          $builder->whereHas('hotel', function ($q) {
            $q->where('moderate', '=', false);
          })->where('moderate', '=', false);
        }
      } else {
         $builder->whereHas('hotel', function ($q) {
            $q->where('moderate', '=', false);
          })->where('moderate', '=', false);
      }
    });
  }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_room', 'room_id', 'attribute_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeHot(Builder $query): Builder
    {
        return $query->where('is_hot', true);
    }

    public function costs(): MorphMany
    {
        return $this->morphMany(Cost::class, 'model');
    }

    public function meta(): HasOne
    {
        return $this->hasOne(PageDescription::class, 'model_id')->where('model_type', self::class);
    }

    public function attachMeta(Request $request): Room
    {
        if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false))
            return $this;

        $key = $this->getRouteKeyName();
        $url = '/rooms/'.$this->$key;

        $data = [];
        $data['title'] = $request->get('meta_title');
        $data['meta_description'] = $request->get('meta_description');
        $data['meta_keywords'] = $request->get('meta_keywords');
        $data['url'] = $url;
        $data['model_type'] = self::class;

        $meta = PageDescription::updateOrCreate(['url' => $url], $data);
        $meta->model_type = self::class;
        $meta->save();

        $this->meta()->save($meta);

        return $this;
    }

    public function getMetaDescriptionAttribute()
    {
        return @$this->meta->meta_description ?? null;
    }

    public function getMetaKeywordsAttribute()
    {
        return @$this->meta->meta_keywords ?? null;
    }

    public function getMetaTitleAttribute()
    {
        return @$this->meta->title ?? null;
    }
}
