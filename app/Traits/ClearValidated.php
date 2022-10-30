<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait ClearValidated
{
    public static function getFillableData($data): array
    {
        $selfClass = new self();
        $fillable = $selfClass->getFillable();

        if ($data instanceof Collection) {
            $dataRaw = $data->toArray();
        } else {
            $dataRaw = (array) $data;
        }

        if (in_array('user_id', $fillable) && ! isset($dataRaw['user_id'])) {
            $dataRaw['user_id'] = Auth::user()->id;
        }

        if (count($fillable) <= 0) {
            return [];
        }

        foreach ($dataRaw as $key => $value) {
            if (! in_array($key, $fillable)) {
                unset($dataRaw[$key]);
            }
        }

        return $dataRaw;
    }

    public function getFillable()
    {
        if ($this->fillable) {
            return $this->fillable;
        }

        return [];
    }
}
