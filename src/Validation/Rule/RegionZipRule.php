<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionZip;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 邮政编码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionZipRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
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
        return (new RegionZip($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The :attribute is incorrect.';
    }
}