<?php

namespace SimpleCMS\Region\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
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
    private function distanceRaw(float $lat, float $lng, string $column = 'location'): string
    {
        return "ST_Distance_Sphere($column,ST_GeomFromText('POINT($lng $lat)',4326))";
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
    public function selectDistance(SimpleService $service, float $lat, float $lng, string $column = 'location', string $alias = 'distance'): SimpleService
    {
        $distanceRaw = $this->distanceRaw($lat, $lng, $column);
        $service->setSelect(DB::raw($distanceRaw . ' AS ' . $alias));
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
    public function queryDistance(SimpleService $service, float $lat, float $lng, float $maxDistance = 50, string $column = 'location'): SimpleService
    {
        $this->selectDistance($service, $lat, $lng, $column);
        $distanceRaw = $this->distanceRaw($lat, $lng, $column);
        $service->appendQuery([
            [
                function (Builder $query) use ($distanceRaw, $maxDistance) {
                    $query->whereRaw("$distanceRaw <= $maxDistance");
                }
            ]
        ]);
        return $service;
    }
}