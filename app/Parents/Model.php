<?php

namespace App\Parents;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    protected static string $orderDirection = 'ASC';
}
