<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Point implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        return explode(',', substr($value, 6, -1));
    }

    public function set($model, $key, $value, $attributes)
    {
        return DB::raw("ST_GeomFromText('POINT($value[0], $value[1])',4326)");
    }
}