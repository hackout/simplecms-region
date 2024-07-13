<?php
namespace SimpleCMS\Region\Validation;


/**
 * 检查邮编
 */
class RegionZip implements RegionInterface
{
    protected string $zip;

    public function __construct(string $zip)
    {
        $this->setZip($zip);
    }

    public function getZip()
    {
        return (string) $this->zip;
    }

    public function setZip(string $zip)
    {
        $this->zip = (string) trim($zip);
    }

    public function isValid(): bool
    {
        return \SimpleCMS\Region\Facades\Region::checkZip($this->zip);
    }
}