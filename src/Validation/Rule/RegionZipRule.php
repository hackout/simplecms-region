<?php
namespace SimpleCMS\Region\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;
use SimpleCMS\Region\Validation\RegionZip;

/**
 * 邮政编码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionZipRule implements Rule
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
        return (new RegionZip($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The zip code is incorrect.';
    }
}