<?php

namespace SimpleCMS\Region\Traits;

use Illuminate\Support\Facades\DB;
use SimpleCMS\Region\Models\Region;

/**
 * 定位信息Trait
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * 使用:
 * 
 *   use \SimpleCMS\Region\Traits\RegionTrait;
 *
 *
 * 请求查询方法:
 *
 *   $query->withGeoDistance(float $lat,float $lng,int $distance = 5000);
 * 
 * @use \Illuminate\Database\Eloquent\Model
 * @use \Illuminate\Database\Eloquent\Concerns\HasRelationships
 *
 */
trait RegionTrait
{

    public static function bootRegionTrait()
    {
        static::deleting(function ($model) {
            $model->region->each(fn(Region $region) => $region->delete());
        });
    }

    /**
     * 关联地区
     * @return mixed
     */
    public function region()
    {
        return $this->morphOne(Region::class, 'model');
    }

    /**
     * 按距离查询
     * @param mixed $query
     * @param array $codes
     * @return mixed
     */
    public function scopeWithGeoDistance($query, float $lat,float $lng,int $distance = 5000)
    {
        $raw = "ST_Distance_Sphere(geo,ST_GeomFromText('POINT($lng $lat)',4326))";
        return $query->whereHas('region', function ($q) use ($raw,$distance) {
            $q->select(DB::raw($raw.' as distance'))->where("distance <= $distance");
        });
    }

}
