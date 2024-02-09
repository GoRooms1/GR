<?php

namespace Support\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniquePhone implements Rule
{
    private $table;

    private $column;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $column = null)
    {
        $this->table = $table;
        $this->column = $column;        
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
        $column = $this->column ?? $attribute;       
        return !DB::table($this->table)
            ->whereRaw("REGEXP_REPLACE(".$column.", '[^0-9]+', '') = ".preg_replace("/[^0-9]/", "", $value))
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {     
        return __('validation-inline.unique');        
    }
}
