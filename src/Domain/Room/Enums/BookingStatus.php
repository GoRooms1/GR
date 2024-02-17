<?php

declare(strict_types=1);

namespace Domain\Room\Enums;

use Illuminate\Support\Str;

enum BookingStatus: string
{
    case Wait = 'wait';
    case StayinAtHotel = 'in';
    case CheckOut = 'out';
    case ClosedByClient = 'cc';
    case ClosedByHotel = 'ch';

    public function trans(): string
    {
        return trans()->hasForLocale('enums.booking.status.'.$this->value) ? trans('enums.booking.status.'.$this->value) : Str::ucfirst(Str::lower(Str::headline($this->name)));
    }

    public function toKeyValue() {
        return [
            'key' => $this->value,
            'value' => $this->trans(),
        ];
    }
}
