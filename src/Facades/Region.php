<?php

namespace SimpleCMS\Region\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SimpleCMS\Region\Packages\Region\Region
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
