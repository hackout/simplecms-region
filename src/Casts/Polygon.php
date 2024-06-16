<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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