<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace  Domain\Room\Models;

use App\User;
use Domain\Review\Models\Review;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *  Domain\Room\Models\Booking
 *
 * @property int         $id
 * @property string      $book_number
 * @property string      $client_fio
 * @property string      $client_phone
 * @property string      $book_type
 * @property string|null $book_comment
 * @property string      $from-date
 * @property string|null $to-date
 * @property int|null    $hours_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Booking newModelQuery()
 * @method static Builder|Booking newQuery()
 * @method static Builder|Booking query()
 * @method static Builder|Booking whereBookComment($value)
 * @method static Builder|Booking whereBookNumber($value)
 * @method static Builder|Booking whereBookType($value)
 * @method static Builder|Booking whereClientFio($value)
 * @method static Builder|Booking whereClientPhone($value)
 * @method static Builder|Booking whereCreatedAt($value)
 * @method static Builder|Booking whereFromDate($value)
 * @method static Builder|Booking whereHoursCount($value)
 * @method static Builder|Booking whereId($value)
 * @method static Builder|Booking whereToDate($value)
 * @method static Builder|Booking whereUpdatedAt($value)
 * @mixin Eloquent
 *
 * @property int|null $room_id
 * @property-read \Domain\Room\Models\Room|null $room
 *
 * @method static Builder|Booking whereRoomId($value)
 *
 * @property bool $on_show
 *
 * @method static Builder|Booking whereOnShow($value)
 */
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
        'on_show',        
        'status',
    ];

    protected $casts = [
        'on_show' => 'boolean',
        'from-date' => 'datetime:Y-m-d\TH:i:sP',
        'to-date' => 'datetime:Y-m-d\TH:i:sP',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',
    ];

    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function review(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Review::class);
    } 

    /**
     * @return string|null
     */
    public function GetTypeAttribute(): string|null
    {
        if ($this->book_type === 'hour') {
            return 'На час';
        } elseif ($this->book_type === 'day') {
            return 'На сутки';
        } elseif ($this->book_type === 'night') {
            return 'На ночь';
        }

        return null;
    }
}
