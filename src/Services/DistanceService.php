<?php

namespace SimpleCMS\Region\Services;

use SimpleCMS\Framework\Services\SimpleService;

class DistanceService
{
    /**
     * 增加距离Select
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleService $service
     * @param  float         $lat
     * @param  float         $lng
     * @param  string        $column
     * @return SimpleService
     */
    public function selectDistance(SimpleService $service, float $lat, float $lng,string $column = 'location'):SimpleService
    {
        $distanceRaw = "ST_Distance_Sphere($column, POINT($lng, $lat)) AS distance";
        $service->setSelectRaw($distanceRaw);
        return $service;
    }

    /**
     * 按距离查询
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleService $service
     * @param  float         $lat
     * @param  float         $lng
     * @param  integer       $maxDistance
     * @param  string        $column
     * @return SimpleService
     */
    public function queryDistance(SimpleService $service, float $lat, float $lng, float $maxDistance = 50,string $column = 'location'):SimpleService
    {
        $distanceRaw = "ST_Distance_Sphere($column, POINT($lng, $lat)) AS distance";
        $service->setSelectRaw($distanceRaw);
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