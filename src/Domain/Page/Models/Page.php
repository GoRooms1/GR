<?php

declare(strict_types=1);

namespace Domain\Page\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use App\User;
use Domain\Image\Traits\UseImages;
use Domain\Page\DataTransferObjects\PageData;
use Domain\Page\Factories\PageFactory;
use Domain\PageDescription\Models\PageDescription;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\WithData;

/**
 * Domain\Page\Models\Page
 *
 * @property int                     $id
 * @property string                  $title
 * @property string                  $slug
 * @property string                  $content
 * @property int|null                $user_id
 * @property Carbon|null             $deleted_at
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property string|null             $header
 * @property string|null             $footer
 * @property-read mixed              $meta_description
 * @property-read mixed              $meta_keywords
 * @property-read mixed              $meta_title
 * @property-read \Domain\Image\Models\Image              $image
 * @property-read Collection|\Domain\Image\Models\Image[] $images
 * @property-read int|null           $images_count
 * @property-read \Domain\PageDescription\Models\PageDescription    $meta
 * @property-read User|null          $user
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUserId($value)
 * @method static Builder|Page withTrashed()
 * @method static Builder|Page withoutTrashed()
 * @method PageData getData()
 * @mixin Eloquent
 */
class Page extends Model
{
    use SoftDeletes;
    use UseImages;
    use CreatedAtOrdered;
    use WithData;
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'header',
        'footer',
    ];

    /** @var string[] */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected string $dataClass = PageData::class;

    protected static function boot()
    {
        parent::boot();
        self::creating(static function (self $page) {
            Cache::forget('sitemap.2g');
        });
        self::updating(static function (self $page) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(static function (self $page) {
            Cache::forget('sitemap.2g');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }    

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function meta(): HasOne
    {
        return $this
          ->hasOne(PageDescription::class, 'model_id')
          ->where('model_type', self::class);
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        return @$this->meta->meta_description ?? null;
    }

    public function getMetaKeywordsAttribute(): ?string
    {
        return @$this->meta->meta_keywords ?? null;
    }

    public function getMetaTitleAttribute(): ?string
    {
        return @$this->meta->title ?? null;
    }

    /**
     * @return array<string|null>
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['created_at'] = $this->created_at?->format(DATE_ATOM);
        $data['updated_at'] = $this->created_at?->format(DATE_ATOM);

        return $data;
    }

    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }
}
