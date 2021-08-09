<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 09.08.2020
 * Time: 16:58
 */

namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class Json
{
    public static function answer(array $data, bool $success, int $status): JsonResponse
    {
        return \response()->json([
            'success' => $success,
            'payload' => $data,
        ], $status);
    }

    public static function good(array $data, int $status = 200): JsonResponse
    {
        return self::answer($data, true, $status);
    }

    public static function bad(array $data, int $status = 400): JsonResponse
    {
        return self::answer($data, false, $status);
    }
}