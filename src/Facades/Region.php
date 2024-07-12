<?php

namespace SimpleCMS\Region\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll()
 * @method static \Illuminate\Support\Collection getAllChildren(string $code)
 * @method static \SimpleCMS\Region\Packages\RegionModel|null findRegion(string $code)
 * @method static \Illuminate\Support\Collection getChildren(string $code, int $deep = 0)
 * @method static bool checkName(string $name)
 * @method static bool checkCode(string $code)
 * @method static bool checkArea(string $area)
 * @method static bool checkNumber(string $number)
 * @method static bool checkZip(string $zip)
 * 
 * @see \SimpleCMS\Region\Packages\Region
 */
class Region extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'region';
    }
}
