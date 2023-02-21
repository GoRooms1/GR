<?php

declare(strict_types=1);

namespace Domain\Attribute\Model;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Domain\Attribute\Builders\AttributeBuilder;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Room;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use function mb_strtolower;
use Spatie\LaravelData\WithData;

/**
 * Domain\Attribute\Model\Attribute
 *
 * @property int                    $id
 * @property string                 $name
 * @property string|null            $description
 * @property class-string            $model
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property bool                $in_filter
 * @property int                    $attribute_category_id
 * @property-read mixed             $category
 * @property-read mixed             $model_name
 * @property-read AttributeCategory $relationCategory
 *
 * @method static Builder|Attribute filtered()
 * @method static Builder|Attribute forHotels()
 * @method static Builder|Attribute forRooms()
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|Attribute whereAttributeCategoryId($value)
 * @method static Builder|Attribute whereCreatedAt($value)
 * @method static Builder|Attribute whereDescription($value)
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereInFilter($value)
 * @method static Builder|Attribute whereModel($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class Attribute extends Model
{
    use CreatedAtOrdered;
    use WithData;

    protected string $dataClass = AttributeData::class;

    public const MODELS_TRANSLATE = [
        Hotel::class => 'Отели',
        Room::class => 'Номера',
    ];

    protected $fillable = [
        'name',
        'description',
        'model',
        'in_filter',
    ];

    protected $casts = [
        'in_filter' => 'boolean',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',
    ];    

    public function getCategoryAttribute(): string
    {
        $model = explode('\\', $this->model);
        $model = end($model);
        $model = mb_strtolower($model);

        return $model;
    }

    public function getModelNameAttribute(): string
    {
        return $this->getAttributes()['model'];
    }

    public function relationCategory(): BelongsTo
    {
        return $this->belongsTo(AttributeCategory::class, 'attribute_category_id', 'id');
    }

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return AttributeBuilder<Attribute>
     */
    public function newEloquentBuilder($query): AttributeBuilder
    {
        return new AttributeBuilder($query);
    }
}
