<?php
namespace SimpleCMS\Region\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;
use SimpleCMS\Region\Validation\RegionArea;

/**
 * 区号
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionAreaRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new RegionArea($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The area code is incorrect.';
    }
}