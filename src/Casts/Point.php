<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Point implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        $srid = $attributes ? head($attributes) : '4326';
        return explode(' ', substr($value, 6, (4 + strlen($srid)) * -1));
    }

    public function set($model, $key, $value, $attributes)
    {
        $srid = $attributes ? head($attributes) : '4326';
        return DB::raw("ST_GeomFromText('POINT($value[0] $value[1])',$srid)");
    }
}