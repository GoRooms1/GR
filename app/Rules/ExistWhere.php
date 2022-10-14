<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistWhere implements Rule
{
    private $table;

    private $need_column;

    private $where_column;

    private $where_column_value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $need_column, $where_column, $where_column_value)
    {
        $this->table = $table;
        $this->need_column = $need_column;
        $this->where_column = $where_column;
        $this->where_column_value = $where_column_value;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($this->table)->where($this->need_column, $value)->where($this->where_column, $this->where_column_value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
