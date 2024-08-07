<?php
namespace SimpleCMS\Region\Packages;

/**
 * 地理信息基础模型
 */
class RegionStatic
{

    /**
     * 行政名称
     *
     * @var string|null
     */
    public string $name;

    /**
     * 简称/短名
     *
     * @var string|null
     */
    public string $short;

    /**
     * 行政编码(具备唯一性)
     *
     * @var string|null
     */
    public string $code;

    /**
     * 电话区号
     *
     * @var string|null
     */
    public string $area;

    /**
     * 邮政编码
     *
     * @var string|null
     */
    public string $zip;

    /**
     * 经度(高德坐标系/GCJ-02/火星坐标)
     *
     * @var float|null
     */
    public float $lng;

    /**
     * 纬度(高德坐标系/GCJ-02/火星坐标)
     *
     * @var float|null
     */
    public float $lat;

    /**
     * 行政区划层级
     * @var int
     */
    public int $deep = 0;

    /**
     * 设置行政区划层级
     * @param int $deep
     * @return void
     */
    public function setDeep(int $deep):void
    {
        $this->deep = $deep;
    }

    /**
     * 获取写入参数
     * @return array
     */
    public function getAttributes():array
    {
        return ['name','short','code','area','zip','lng','lat'];
    }
}