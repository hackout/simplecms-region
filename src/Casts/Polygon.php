<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @template TGet
 * @template TSet
 */
class Polygon implements CastsAttributes
{

    /**
     * Transform the attribute from the underlying model values.
     * 
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<string, mixed>  $attributes
     * @return TGet|null
     */
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }


    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  TSet|null  $value
     * @param  array<string, mixed>  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}