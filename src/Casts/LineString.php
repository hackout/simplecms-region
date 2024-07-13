<?php
namespace SimpleCMS\Region\Casts;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LineString implements CastsAttributes
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
            $tableName = $model->getTable();
            $keyName = $model->getKeyName();
            $keyValue = $model->$keyName;
            $value = DB::select("SELECT ST_AsText($key) as $key FROM $tableName WHERE $keyName = '$keyValue'")[0]->$key;
            if (empty($value)) {
                return null;
            }
        }

        $pointString = str_replace(['LINESTRING(', ')'], '', $value);

        $points = explode(',', $pointString);

        $decoded = array_map(function ($point) {
            $_value = array_reverse(explode(' ', trim($point)));
            return [(float) $_value[0], (float) $_value[1]];
        }, $points);

        return $decoded;
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
        $array = Arr::map($value, function ($rs) {
            return Arr::join(array_reverse($rs), ' ');
        });
        return DB::raw("ST_GeomFromText('LINESTRING(" . Arr::join($array, ',') . ")',$srid)");
    }
}