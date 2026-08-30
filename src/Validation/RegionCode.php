<?php
namespace SimpleCMS\Region\Validation;


/**
 * 检查行政代码
 */
class RegionCode implements RegionInterface
{
    protected string $code;

    public function __construct(string $code)
    {
        $this->setCode($code);
    }

    public function getCode()
    {
        return (string) $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = (string) trim($code);
    }

    public function isValid(): bool
    {
        return \SimpleCMS\Region\Facades\Region::checkCode($this->code);
    }
}