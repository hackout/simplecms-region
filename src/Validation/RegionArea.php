<?php
namespace SimpleCMS\Region\Validation;


/**
 * 检查区号
 */
class RegionArea
{
    protected string $area;

    public function __construct(string $area)
    {
        $this->setArea($area);
    }

    public function getArea()
    {
        return (string) $this->area;
    }

    public function setArea(string $area)
    {
        $this->area = (string) trim($area);
    }

    public function isValid(): bool
    {
        return \SimpleCMS\Region\Facades\Region::checkArea($this->area);
    }
}