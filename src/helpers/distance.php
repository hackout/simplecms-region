<?php

/**
 * 计算距离
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @param  float   $lat1 维度
 * @param  float   $lon1 经度
 * @param  float   $lat2 维度2
 * @param  float   $lon2 经度2
 * @return float
 */
function distance(float $lat1, float $lon1, float $lat2, float $lon2): float
{
    $earthRadius = 6371;

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c;

    return $distance;
}