<?php

namespace App\Models;

use App\Parents\Model;
use App\Traits\ClearValidated;
use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Support\Dates\Traits\RusMonth;

/**
 * App\Models\Article
 *
 * @property int                     $id
 * @property string                  $title
 * @property string                  $slug
 * @property string                  $notice
 * @property string                  $content
 * @property int|null                $user_id
 * @property string|null             $deleted_at
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property-read Image              $image
 * @property-read Collection|Image[] $images
 * @property-read int|null           $images_count
 * @property-read User|null          $user
 *
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article query()
 * @method static Builder|Article whereContent($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDeletedAt($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereNotice($value)
 * @method static Builder|Article whereSlug($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article whereUserId($value)
 * @mixin Eloquent
 */
class Article extends Model
{
    use UseImages;
    use RusMonth;
    use ClearValidated;
    use CreatedAtOrdered;

    protected $fillable = [
        'title',
        'notice',
        'content',
        'slug',
        'user_id',
    ];

    protected $with = [
        'image',
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::creating(function (self $article) {
            Cache::forget('sitemap.2g');
        });
        self::updating(function (self $article) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(function (self $article) {
            Cache::forget('sitemap.2g');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
