<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionCode;
use SimpleCMS\Region\Validation\RegionRule;

/**
 * 行政代码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionCodeRule extends RegionRule
{
    public ?string $ruleClass = RegionCode::class;
}