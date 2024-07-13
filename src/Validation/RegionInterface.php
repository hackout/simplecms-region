<?php
namespace SimpleCMS\Region\Validation;

/**
 * 校验
 */
interface RegionInterface
{
    /**
     * 校验真伪
     * @return bool
     */
    public function isValid(): bool;
}