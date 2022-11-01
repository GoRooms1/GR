<?php

declare(strict_types=1);

namespace Domain\Image\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Domain\Image\Models\Image
 *
 * @property int             $id
 * @property string|string[] $path
 * @property string          $name
 * @property bool            $moderate
 * @property string|null     $title
 * @property string|null     $description
 * @property int|null        $default
 * @property string|null     $model_type
 * @property int|null        $model_id
 * @property int|null        $order
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 *
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereDefault($value)
 * @method static Builder|Image whereDescription($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereModelId($value)
 * @method static Builder|Image whereModelType($value)
 * @method static Builder|Image whereModerate($value)
 * @method static Builder|Image whereName($value)
 * @method static Builder|Image wherePath($value)
 * @method static Builder|Image whereTitle($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @method static Builder|Image whereOrder($value)
 * @mixin Eloquent
 */
final class Image extends Model
{
    use CreatedAtOrdered;

    public const DEFAULT = 'img/img-hotel.jpg';

    protected static string $orderDirection = 'ASC';

    public $casts = [
        'moderate' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'path',
        'moderate',
        'order',
    ];

    /**
     * Меняем урлу картинки на урлу с оптимизацией
     *
     * @param  string  $value
     * @return string|string[]
     */
    public function getPathAttribute(string $value): string|array
    {
        return str_replace('storage', 'image', $value);
    }
}
