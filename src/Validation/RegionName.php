<?php
namespace SimpleCMS\Region\Validation;


/**
 * 检查地区名称
 */
class RegionName
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName()
    {
        return (string) $this->name;
    }

    public function setName(string $name)
    {
        $this->name = (string) trim($name);
    }

    public function isValid(): bool
    {
        return \SimpleCMS\Region\Facades\Region::checkName($this->name);
    }
}