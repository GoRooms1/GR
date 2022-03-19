<?php

namespace App\Models;

use DB;
use Str;
use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Metro
 *
 * @property int         $id
 * @property string      $color
 * @property string      $name
 * @property int         $distance
 * @property int         $hotel_id
 * @property bool        $custom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Hotel  $hotel
 * @method static Builder|Metro newModelQuery()
 * @method static Builder|Metro newQuery()
 * @method static Builder|Metro query()
 * @method static Builder|Metro whereColor($value)
 * @method static Builder|Metro whereCreatedAt($value)
 * @method static Builder|Metro whereDistance($value)
 * @method static Builder|Metro whereHotelId($value)
 * @method static Builder|Metro whereId($value)
 * @method static Builder|Metro whereName($value)
 * @method static Builder|Metro whereUpdatedAt($value)
 * @method static Builder|Metro whereCustom($value)
 * @mixin Eloquent
 */
class Metro extends Model
{
  public const COLORS = [
    'green'       => 'Зелёный',
    'red'         => 'Красный',
    'yellow'      => 'Жёлтый',
    'blue'        => 'Синий',
    'light-blue'  => 'Голубой',
    'brown'       => 'Коричневый',
    'orange'      => 'Оранжевая',
    'purple'      => 'Фиолетовая',
    'grey'        => 'Серая',
    'lime'        => 'Салатовая',
    'teal'        => 'Бирюзовая',
    'blue-gray'   => 'Серо-голубая',
  ];

  public const ARRAY_COLORS = [
    'green',
    'red',
    'yellow',
    'blue',
    'light-blue',
    'brown',
    'orange',
    'purple',
    'grey',
    'lime',
    'teal',
    'blue-gray',
  ];

  public const COLORS_HEX = [
    'green'       => '00FF00',
    'red'         => 'FF0000',
    'yellow'      => 'FFFF00',
    'blue'        => '0000FF',
    'light-blue'  => '80A6FF',
    'brown'       => '964b00',
    'orange'      => 'ffa500',
    'purple'      => '8b00ff',
    'grey'        => '808080',
    'lime'        => '7fff00',
    'teal'        => '30d5c8',
    'blue-gray'   => '77a1b5',
  ];

  protected $fillable = [
    'color',
    'name',
    'distance',
    'hotel_id',
    'custom',
  ];

  protected $casts = [
    'custom' => 'boolean',
  ];

  public function hotel(): BelongsTo
  {
    return $this->belongsTo(Hotel::class);
  }

  public static function generateSlug(Metro $metro): void
  {
    DB::table('address_slug')->updateOrInsert(['address' => $metro->name], [
      'address' => $metro->name,
      'slug' => Str::slug($metro->name)
    ]);
  }
}
