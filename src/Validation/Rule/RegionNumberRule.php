<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionRule;
use SimpleCMS\Region\Validation\RegionNumber;

/**
 * 电话号码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionNumberRule extends RegionRule
{
    public ?string $ruleClass = RegionNumber::class;
}