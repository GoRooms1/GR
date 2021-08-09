<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 09.08.2020
 * Time: 19:17
 */

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class CreatedAtOrderScope implements Scope
{

    private $direction;

    public function __construct($direction = 'DESC')
    {
        $this->direction = $direction;
    }

    public function apply(Builder $builder, $model)
    {
        $builder->orderBy('created_at', $this->direction);
    }
}