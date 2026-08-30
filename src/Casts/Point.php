<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Point implements CastsAttributes
{
    /**
     * Summary of select
     * @param mixed $field
     * @return string
     */
    public static function select($field): string
    {
        return "ST_AsText($field) as $field";
    }

    /**
     * Transform the attribute from the underlying model values.
     * 
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<string, mixed>  $attributes
     * @return mixed
     */
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

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<string, mixed>  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        $srid = 4326;
        return DB::raw("ST_GeomFromText('POINT($value[0] $value[1])',$srid)");
    }
}