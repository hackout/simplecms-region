<?php

namespace SimpleCMS\Region\Services;

use SimpleCMS\Framework\Services\SimpleService;

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
    protected function distanceRaw(float $lat, float $lng,string $column = 'location'):string
    {
        return "ST_Distance_Sphere($column, ST_SetSRID(ST_MakePoint($lng, $lat), 4326)) AS distance";
    }

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
        $distanceRaw = $this->distanceRaw($lat,$lng,$column);
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
        $this->selectDistance($service,$lat,$lng,$column);
        $distanceRaw = $this->distanceRaw($lat,$lng,$column);
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