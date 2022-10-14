<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Form
 *
 * @property int         $id
 * @property string      $fields
 * @property string      $page
 * @property string      $ip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Form newModelQuery()
 * @method static Builder|Form newQuery()
 * @method static Builder|Form query()
 * @method static Builder|Form whereCreatedAt($value)
 * @method static Builder|Form whereFields($value)
 * @method static Builder|Form whereId($value)
 * @method static Builder|Form whereIp($value)
 * @method static Builder|Form wherePage($value)
 * @method static Builder|Form whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Form extends Model
{
  //
}
