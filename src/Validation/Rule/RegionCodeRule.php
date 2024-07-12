<?php
namespace SimpleCMS\Region\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;
use SimpleCMS\Region\Validation\RegionCode;

/**
 * 行政代码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionCodeRule implements Rule
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
        return (new RegionCode($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The code of region is incorrect.';
    }
}