<?php
namespace SimpleCMS\Region\Validation;


/**
 * 检查电话号码
 */
class RegionNumber
{
    protected string $number;

    public function __construct(string $number)
    {
        $this->setNumber($number);
    }

    public function getNumber()
    {
        return (string) $this->number;
    }

    public function setNumber(string $number)
    {
        $this->number = (string) trim($number);
    }

    public function isValid(): bool
    {
        return \SimpleCMS\Region\Facades\Region::checkNumber($this->number);
    }
}