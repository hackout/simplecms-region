<?php

namespace SimpleCMS\Region\Services;

use SimpleCMS\Framework\Services\SimpleService;

class DistanceService
{
    protected string $latKey = 'lat';
    protected string $lngKey = 'lng';
    public function __construct(?string $latKey = 'lat', ?string $lngKey = 'lng')
    {
        $this->latKey = $latKey;
        $this->lngKey = $lngKey;
    }

    public function queryDistance(SimpleService $service, float $lat, float $lng, float $maxDistance = 50)
    {
        $distanceSql = "(6371 * acos(cos(radians($lat)) * cos(radians($this->lngKey)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians($this->latKey))))";
        $service->setSelectRaw("$distanceSql AS distance");
        $service->appendQuery([
            [
                function ($query) use ($distanceSql, $maxDistance) {
                    $query->whereRaw("$distanceSql <= $maxDistance");
                }
            ]
        ]);
        return $service;
    }
}