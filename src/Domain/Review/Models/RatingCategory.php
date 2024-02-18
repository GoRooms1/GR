<?php

namespace  Domain\Review\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *  Domain\Review\Models\RatingCategory
 *
 * @property int         $id
 * @property string      $name
 * @property int         $sort
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|RatingCategory newModelQuery()
 * @method static Builder|RatingCategory newQuery()
 * @method static Builder|RatingCategory query()
 * @method static Builder|RatingCategory whereCreatedAt($value)
 * @method static Builder|RatingCategory whereId($value)
 * @method static Builder|RatingCategory whereName($value)
 * @method static Builder|RatingCategory whereSort($value)
 * @method static Builder|RatingCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class RatingCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort',
    ];
}
