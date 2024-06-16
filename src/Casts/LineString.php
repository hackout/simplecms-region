<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LineString implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        if ($value === null || strlen($value) < 21) {
            return null;
        }

        $data = unpack('H*', $value);
        $data = array_shift($data);

        $pairs = str_split(substr($data, 8), 16);
        $points = array_map(function ($pair) {
            list($lat, $lon) = array_map(function ($coord) {
                return hexdec($coord);
            }, str_split($pair, 8));
            
            $lon = $lon > 2147483647 ? $lon - 4294967296 : $lon;
            $lat = $lat > 2147483647 ? $lat - 4294967296 : $lat;

            return [$lat / 10000000, $lon / 10000000];
        }, $pairs);

        return $points;
    }

    public function set($model, $key, $value, $attributes)
    {
        $srid = $attributes ? head($attributes) : '4326';
        $lineStrings = array_chunk($value, 2);
        $array = Arr::map($lineStrings, function ($rs) {
            return Arr::join($rs, ' ');
        });
        return DB::raw("ST_GeomFromText('LINESTRING(" . Arr::join($array, ',') . ")',$srid)");
    }
}