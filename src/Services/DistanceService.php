<?php

namespace SimpleCMS\Region\Services;


/**
 * @package simplecms/framework
 */
class DistanceService
{

    /**
     * 获取距离RawString
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  float  $lat
     * @param  float  $lng
     * @param  string $column
     * @return string
     */
    protected function distanceRaw(float $lat, float $lng, string $column = 'location'): string
    {
        return "ST_Distance_Sphere($column,ST_GeomFromText('POINT($lng $lat)',4326))";
    }

    /**
     * 增加距离Select
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  \SimpleCMS\Framework\Services\SimpleService $service
     * @param  float         $lat
     * @param  float         $lng
     * @param  string        $column
     * @return \SimpleCMS\Framework\Services\SimpleService
     */
    public function selectDistance(\SimpleCMS\Framework\Services\SimpleService $service, float $lat, float $lng, string $column = 'location', string $alias = 'distance'): \SimpleCMS\Framework\Services\SimpleService
    {
        $distanceRaw = $this->distanceRaw($lat, $lng, $column);
        $service->setSelectRaw($distanceRaw . ' AS ' . $alias);
        return $service;
    }

    /**
     * 按距离查询
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  \SimpleCMS\Framework\Services\SimpleService $service
     * @param  float         $lat
     * @param  float         $lng
     * @param  integer       $maxDistance
     * @param  string        $column
     * @return \SimpleCMS\Framework\Services\SimpleService
     */
    public function queryDistance(\SimpleCMS\Framework\Services\SimpleService $service, float $lat, float $lng, float $maxDistance = 50, string $column = 'location'): \SimpleCMS\Framework\Services\SimpleService
    {
        $this->selectDistance($service, $lat, $lng, $column);
        $distanceRaw = $this->distanceRaw($lat, $lng, $column);
        $service->appendQuery([
            [
                function ($query) use ($distanceRaw, $maxDistance) {
                    $query->whereRaw("$distanceRaw <= $maxDistance");
                }
            ]
        ]);
        return $service;
    }
}