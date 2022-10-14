<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\FormEvent
 *
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|FormEvent newModelQuery()
 * @method static Builder|FormEvent newQuery()
 * @method static Builder|FormEvent query()
 * @method static Builder|FormEvent whereCreatedAt($value)
 * @method static Builder|FormEvent whereId($value)
 * @method static Builder|FormEvent whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FormEvent extends Model
{
  //
}
