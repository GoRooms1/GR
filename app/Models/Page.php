<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    use SoftDeletes;
    use UseImages;
    use CreatedAtOrdered;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'header',
        'footer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meta(): HasOne
    {
        return $this->hasOne(PageDescription::class, 'model_id')->where('model_type', self::class);
    }

    public function attachMeta(Request $request): Page
    {

        if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false))
            return $this;

        $key = $this->getRouteKeyName();
        $url = '/'.$this->$key;

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
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::creating(function(self $page) {
            Cache::forget('sitemap.2g');
        });
        self::updating(function(self $page) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(function(self $page) {
            Cache::forget('sitemap.2g');
        });
    }
}
