<?php
namespace SimpleCMS\Region\Validation;

use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 自定义验证规则
 */
class RegionRule implements ValidationRule
{

    /**
     * 校验参数类
     *
     * @var string|null
     * @author Dennis Lui <hackout@vip.qq.com>
     */
    public ?string $ruleClass = null;

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
        if (!$this->passes($value)) {
            $fail($this->message($attribute));
        }
    }

    /**
     * 获取模型方法类
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  mixed          $value
     * @return RegionInterface
     */
    protected function getRule($value): RegionInterface
    {
        $className = $this->ruleClass;
        return new $className($value);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function passes($value)
    {
        if (!$this->ruleClass)
            return false;
        return $this->getRule($value)->isValid();
    }

    /**
     * Summary of message
     * @param string $attribute
     * @return string
     */
    public function message(string $attribute)
    {
        return "The {$attribute} is incorrect.";
    }
}