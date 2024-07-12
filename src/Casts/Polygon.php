<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Polygon implements CastsAttributes
{

    /**
     * Summary of get
     * @param mixed $model
     * @param mixed $key
     * @param mixed $value
     * @param mixed $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }

    /**
     * Summary of set
     * @param mixed $model
     * @param mixed $key
     * @param mixed $value
     * @param mixed $attributes
     * @return bool|string
     */
    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}