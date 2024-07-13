<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionName;
use SimpleCMS\Region\Validation\RegionRule;

/**
 * 区划名称
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionNameRule extends RegionRule
{
    public ?string $ruleClass = RegionName::class;
}