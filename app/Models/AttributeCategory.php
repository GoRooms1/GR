<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Categories for Attributes
 */
class AttributeCategory extends Model
{
  /**
   * @var string[]
   */
  protected $fillable = [
    'name'
  ];

  /**
   * Attributed
   *
   * @return HasMany
   */
  public function attributes(): HasMany
  {
    return $this->hasMany(Attribute::class);
  }
}
