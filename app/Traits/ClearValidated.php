<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 30.07.2020
 * Time: 0:53
 */
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait ClearValidated {
    public static function getFillableData($data): array {
        $selfClass = new static();
        $fillable = $selfClass->getFillable();

        if ($data instanceof Collection) {
            $dataRaw = $data->toArray();
        } else {
            $dataRaw = (array) $data;
        }

        if (in_array('user_id', $fillable) && !isset($dataRaw['user_id']))
            $dataRaw['user_id'] = Auth::user()->id;

        if (count($fillable) <= 0)
            return [];

        foreach($dataRaw AS $key => $value) {
            if (!in_array($key, $fillable))
                unset($dataRaw[$key]);
        }

        return $dataRaw;
    }

    public function getFillable() {
        if (isset($this->fillable))
            return $this->fillable;
        return [];
    }
}