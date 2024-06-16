<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LineString implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        $array = explode(',', substr($value, 11, -1));
        return Arr::map($array, function ($rs) {
            return explode(" ", $rs);
        });
    }

    public function set($model, $key, $value, $attributes)
    {
        $lineStrings = array_chunk($value, 2);
        $array = Arr::map($lineStrings, function ($rs) {
            return Arr::join($rs, ' ');
        });
        return DB::raw("ST_GeomFromText('LINESTRING(" . Arr::join($array, ',') . ")',4326)");
    }
}