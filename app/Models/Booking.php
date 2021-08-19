<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  protected $fillable = [
    'id',
    'book_number',
    'client_fio',
    'client_phone',
    'book_type',
    'book_comment',
    'from-date',
    'to-date',
    'hours_count',
  ];
}
