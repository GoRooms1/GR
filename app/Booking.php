<?php

namespace App;

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
