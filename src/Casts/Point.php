<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Point implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        if (empty($value)) {
            return null;
        }

        $value = bin2hex($value);

        $value = unpack("x/x/x/x/corder/Ltype/dlat/dlon", pack("H*", $value));

        return [$value['lat'], $value['lon']];
    }

    public function set($model, $key, $value, $attributes)
    {
        $srid = 4326;
        return DB::raw("ST_GeomFromText('POINT($value[0] $value[1])',$srid)");
    }
}