<?php

namespace SimpleCMS\Region\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Region\Casts\Point;

/**
 * Region Model
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string $name 社区名称
 * @property string $city_code 城市代码
 * @property string $city 城市名称
 * @property string $province_code 省份名称
 * @property string $province 省份名称
 * @property string $county_code 县区名称
 * @property string $county 县区名称
 * @property ?array $geo 地理信息
 * @property string $address 地址
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?\Illuminate\Database\Eloquent\Relations\MorphTo $model 关联模型
 */
class Region extends Model
{
    
    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'name',
        'city_code',
        'city',
        'province_code',
        'province',
        'county_code',
        'county',
        'geo',
        'address'
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'geo' => Point::class
    ];

    /**
     * 关联模型
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return ?\Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
