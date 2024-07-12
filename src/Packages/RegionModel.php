<?php
namespace SimpleCMS\Region\Packages;

use Illuminate\Support\Collection;

/**
 * 地理模块
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionModel extends RegionStatic implements \JsonSerializable
{

    /**
     * 离中心点距离
     *
     * @var float|null
     */
    public float $distance = 0;

    /**
     * 下级
     *
     * @var Collection<RegionModel>
     */
    public Collection $children;

    /**
     * 上级
     * @var RegionModel|null
     */
    public ?RegionModel $parent = null;

    public function __construct()
    {
        $this->children = collect();
    }

    /**
     * 设置模型
     * @param array $data
     * @param ?RegionStatic $parent
     * @return \SimpleCMS\Region\Packages\RegionModel
     */
    public function setData(array $data, ?RegionStatic $parent = null): self
    {
        $this->initData($data, $parent);
        return $this;
    }

    protected function initData(array $data, ?RegionStatic $parent = null)
    {
        $this->name = array_key_exists('name', $data) && $data['name'] ? trim($data['name']) : null;
        $this->short = array_key_exists('short', $data) && $data['short'] ? trim($data['short']) : null;
        $this->code = array_key_exists('code', $data) && $data['code'] ? trim($data['code']) : null;
        $this->area = array_key_exists('area', $data) && $data['area'] ? trim($data['area']) : null;
        $this->zip = array_key_exists('zip', $data) && $data['zip'] ? trim($data['zip']) : null;
        $this->lng = array_key_exists('lng', $data) && $data['lng'] ? (float) $data['lng'] : 0;
        $this->lat = array_key_exists('lat', $data) && $data['lat'] ? (float) $data['lat'] : 0;
        $this->parent = $parent;
        if (array_key_exists('children', $data) && $data['children']) {
            foreach ($data['children'] as $child) {
                $_child = new static();
                $_child->setData($child, $this->cloneRegion());
                $this->children->push($_child);
            }
        }
    }

    /**
     * 复制
     * @return RegionStatic
     */
    protected function cloneRegion(): RegionStatic
    {
        $self = new static();
        $self->name = $this->name;
        $self->short = $this->short;
        $self->code = $this->code;
        $self->area = $this->area;
        $self->zip = $this->zip;
        $self->lng = $this->lng;
        $self->lat = $this->lat;
        return $self;
    }

    /**
     * toArray
     * @return array<string,null|string|float|int|array<string,null|string|float|int|mixed>>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name ?? null,
            'short' => $this->short ?? null,
            'code' => $this->code ?? 0,
            'area' => $this->area ?? 0,
            'zip' => $this->zip ?? 0,
            'lng' => $this->lng ?? 0,
            'lat' => $this->lat ?? 0,
            'distance' => $this->distance ?? 0,
            'children' => $this->children->toArray()
        ];

        return $data;
    }

    /**
     * 检查名称有效性
     *
     * @param string $name
     * @return bool
     */
    public function checkName(string $name): bool
    {
        return $this->name == $name || $this->short == $name;
    }

    /**
     * 检查代码有效性
     *
     * @param string $code
     * @return bool
     */
    public function checkCode(string $code): bool
    {
        return $this->code == $code;
    }

    /**
     * 检查区号有效性
     *
     * @param string $area
     * @return bool
     */
    public function checkArea(string $area): bool
    {
        return $this->area == $area;
    }

    /**
     * 检查电话号码有效性
     *
     * @param string $number
     * @return bool
     */
    public function checkNumber(string $number): bool
    {
        if (strlen($number) < 10)
            return false;
        $area = substr($number, 0, strlen($this->area));
        return $this->area == $area;
    }

    /**
     * 检查邮编有效性
     *
     * @param string $zip
     * @return bool
     */
    public function checkZip(string $zip): bool
    {
        return substr($this->zip, 0, 5) == substr($zip, 0, 5);
    }

    /**
     * 设置并返回距离
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  float $lat
     * @param  float $lng
     * @return float
     */
    public function setDistance(float $lat, float $lng): float
    {
        $this->distance = $this->calculateDistance($lat, $lng, $this->lat, $this->lng);
        return $this->distance;
    }

    /**
     * 计算距离
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  float $lat1
     * @param  float $lon1
     * @param  float $lat2
     * @param  float $lon2
     * @return float
     */
    protected function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * jsonSerialize
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * __toString
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * 获取上级
     * @return RegionStatic|null
     */
    public function getParent(): ?RegionStatic
    {
        return $this->parent;
    }
}