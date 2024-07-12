<?php
namespace SimpleCMS\Region\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;
use SimpleCMS\Region\Validation\RegionName;

/**
 * 区划名称
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionNameRule implements Rule
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
        return (new RegionName($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The name of region is incorrect.';
    }
}