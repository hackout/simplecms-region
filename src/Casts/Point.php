<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Point implements CastsAttributes
{
    public static function select($field): string
    {
        return "ST_AsText($field) as $field";
    }

    public function get($model, $key, $value, $attributes)
    {
        if (empty($value)) {
            return null;
        }

        if (!is_string($value) || !mb_check_encoding($value, 'UTF-8')) {
            $value = bin2hex($value);

            $value = unpack("x/x/x/x/corder/Ltype/dlat/dlon", pack("H*", $value));

            return [(float) $value['lat'], (float) $value['lon']];
        }

        $pointString = str_replace(['POINT(', ')'], '', $value);
        $_value = array_reverse(explode(' ', trim($pointString)));

        return [(float) $_value[0], (float) $_value[1]];
    }

    public function set($model, $key, $value, $attributes)
    {
        $srid = 4326;
        return DB::raw("ST_GeomFromText('POINT($value[0] $value[1])',$srid)");
    }
}