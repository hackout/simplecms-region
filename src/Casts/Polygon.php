<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Polygon implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}