<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionNumber;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 电话号码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionNumberRule implements ValidationRule
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
        return (new RegionNumber($value))->isValid();
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