<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionArea;
use SimpleCMS\Region\Validation\RegionRule;

/**
 * 区号
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionAreaRule extends RegionRule
{
    public ?string $ruleClass = RegionArea::class;
}