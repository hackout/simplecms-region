<?php
namespace SimpleCMS\Region\Validation\Rule;

use SimpleCMS\Region\Validation\RegionZip;
use SimpleCMS\Region\Validation\RegionRule;

/**
 * 邮政编码
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionZipRule extends RegionRule
{
    public ?string $ruleClass = RegionZip::class;
}