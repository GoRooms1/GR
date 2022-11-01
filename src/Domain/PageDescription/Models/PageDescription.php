<?php

namespace Domain\PageDescription\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Domain\Image\Models\Image;
use Domain\Image\Traits\UseImages;
use Domain\Page\DataTransferObjects\PageData;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\WithData;

/**
 * Domain\PageDescription\Models\PageDescription
 *
 * @property int                     $id
 * @property string                  $url
 * @property string|null             $title
 * @property string|null             $meta_description
 * @property string|null             $meta_keywords
 * @property string|null             $description
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property string|null             $model_type
 * @property int|null                $model_id
 * @property string|null             $h1
 * @property string                  $type
 * @property-read Image              $image
 * @property-read Collection|\Domain\Image\Models\Image[] $images
 * @property-read int|null           $images_count
 *
 * @method static Builder|PageDescription newModelQuery()
 * @method static Builder|PageDescription newQuery()
 * @method static Builder|PageDescription query()
 * @method static Builder|PageDescription whereCreatedAt($value)
 * @method static Builder|PageDescription whereDescription($value)
 * @method static Builder|PageDescription whereId($value)
 * @method static Builder|PageDescription whereMetaDescription($value)
 * @method static Builder|PageDescription whereMetaKeywords($value)
 * @method static Builder|PageDescription whereModelId($value)
 * @method static Builder|PageDescription whereModelType($value)
 * @method static Builder|PageDescription whereTitle($value)
 * @method static Builder|PageDescription whereUpdatedAt($value)
 * @method static Builder|PageDescription whereUrl($value)
 * @method static Builder|PageDescription whereH1($value)
 * @method static Builder|PageDescription whereType($value)
 * @mixin Eloquent
 */
class PageDescription extends Model
{
    use UseImages;
    use CreatedAtOrdered;
    use WithData;

    /**
     * Fill rows
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'title',
        'meta_description',
        'meta_keywords',
        'description',
        'h1',
        'type',
        'updated_at',
    ];

    protected string $dataClass = PageData::class;

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        self::creating(static function (self $pageDescription) {
            Cache::forget('sitemap.2g');
        });
        self::updating(static function (self $pageDescription) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(static function (self $pageDescription) {
            Cache::forget('sitemap.2g');
        });
    }
}
