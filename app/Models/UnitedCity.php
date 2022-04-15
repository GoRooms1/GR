<?php

namespace App\Models;

use DB;
use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\UnitedCity
 *
 * @property int         $id
 * @property string      $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UnitedCity newModelQuery()
 * @method static Builder|UnitedCity newQuery()
 * @method static Builder|UnitedCity query()
 * @method static Builder|UnitedCity whereCreatedAt($value)
 * @method static Builder|UnitedCity whereDescription($value)
 * @method static Builder|UnitedCity whereId($value)
 * @method static Builder|UnitedCity whereName($value)
 * @method static Builder|UnitedCity whereUpdatedAt($value)
 * @mixin Eloquent
 */
class UnitedCity extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
  ];

  public function united(): Collection
  {
    return DB::table('united_cities_address')->where('united_city', $this->id)->pluck('city_name');
  }
}
