<?php
namespace SimpleCMS\Region\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;
use SimpleCMS\Region\Validation\RegionNumber;

/**
 * 电话号码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionNumberRule implements Rule
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
        return (new RegionNumber($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The phone number is incorrect.';
    }
}