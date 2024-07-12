<?php
namespace SimpleCMS\Region\Packages;


use Illuminate\Support\Collection;

/**
 * 地理模块
 */
class Region
{
    protected Collection $regions;

    public function __construct(protected string $region_path)
    {
        $this->regions = new Collection();
        $this->loadRegions();
    }

    protected function loadRegions(): void
    {
        $content = file_get_contents(env('REGION_PATH', $this->region_path));
        try {
            $data = json_decode($content, true);
            foreach ($data as $region) {
                $this->regions->push($this->convertRegion($region));
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    protected function convertRegion(array $region, ?RegionModel $parent = null): RegionModel
    {
        $obj = new RegionModel();
        $obj->name = array_key_exists('name', $region) && $region['name'] ? trim($region['name']) : null;
        $obj->short = array_key_exists('short', $region) && $region['short'] ? trim($region['short']) : null;
        $obj->code = array_key_exists('code', $region) && $region['code'] ? trim($region['code']) : null;
        $obj->area = array_key_exists('area', $region) && $region['area'] ? trim($region['area']) : null;
        $obj->zip = array_key_exists('zip', $region) && $region['zip'] ? trim($region['zip']) : null;
        $obj->lng = array_key_exists('lng', $region) && $region['lng'] ? (float) $region['lng'] : 0;
        $obj->lat = array_key_exists('lat', $region) && $region['lat'] ? (float) $region['lat'] : 0;
        $obj->parent = $parent;

        if (array_key_exists('children', $region) && $region['children']) {
            foreach ($region['children'] as $child) {
                $obj->children->push($this->convertRegion($child, $obj));
            }
        }
        return $obj;
    }

    /**
     * 获取所有城市列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->regions;
    }

    /**
     * 获取所有下级
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string     $code
     * @return Collection
     */
    public function getAllChildren(string $code): Collection
    {
        $children = new Collection();

        foreach ($this->regions as $region) {
            $children = $this->findAllChildrenRecursively($region, $code);
            if ($children->isNotEmpty()) {
                break;
            }
        }

        return $children;
    }

    /**
     * 检查名称有效性
     *
     * @param string $name
     * @return bool
     */
    public function checkName(string $name): bool
    {
        $regions = $this->getFlattenData();
        return $regions->contains(fn(RegionModel $region) => $region->checkName($name));
    }

    /**
     * 检查行政代码有效性
     *
     * @param string $code
     * @return bool
     */
    public function checkCode(string $code): bool
    {
        $regions = $this->getFlattenData();
        return $regions->contains(fn(RegionModel $region) => $region->checkCode($code));
    }

    /**
     * 检查区号有效性
     *
     * @param string $area
     * @return bool
     */
    public function checkArea(string $area): bool
    {
        $regions = $this->getFlattenData();
        return $regions->contains(fn(RegionModel $region) => $region->checkArea($area));
    }

    /**
     * 检查电话号码有效性
     *
     * @param string $number
     * @return bool
     */
    public function checkNumber(string $number): bool
    {
        $regions = $this->getFlattenData();
        return $regions->contains(fn(RegionModel $region) => $region->checkNumber($number));
    }

    /**
     * 检查邮编有效性
     *
     * @param string $zip
     * @return bool
     */
    public function checkZip(string $zip): bool
    {
        $regions = $this->getFlattenData();
        return $regions->contains(fn(RegionModel $region) => $region->checkZip($zip));
    }

    protected function getFlattenData(): Collection
    {
        $newRegions = new Collection();
        $this->regions->each(function (RegionModel $region) use ($newRegions) {
            $newRegions->add($this->flatten($region));
        });
        return $newRegions->flatten(10);
    }

    /**
     * 查找地区
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $code
     * @return RegionModel|null
     */
    public function findRegion(string $code): ?RegionModel
    {
        $regions = $this->getFlattenData();
        return $regions->first(fn(RegionModel $region) => $region->code == $code);
    }

    /**
     * 平铺数组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array<int,RegionModel>
     * 
     */
    protected function flatten(RegionModel $region): array
    {
        $children = $region->children;
        $region->children = new Collection();
        $newArray = [
            $region
        ];
        if ($children) {
            foreach ($children as $child) {
                $newArray[] = $this->flatten($child);
            }
        }
        return $newArray;
    }

    /**
     * 获取下级城市
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string     $code 地理标识
     * @param  int        $deep  返回携带子级深度，0 标识无children
     * @return Collection
     */
    public function getChildren(string $code, int $deep = 0): Collection
    {
        $children = new Collection();

        foreach ($this->regions as $region) {
            $children = $this->findChildrenRecursively($region, $code, $deep);
            if ($children->isNotEmpty()) {
                break;
            }
        }

        return $children;
    }

    /**
     * 查询子级
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  RegionModel $region
     * @param  string      $code
     * @return Collection
     */
    protected function findChildrenRecursively(RegionModel $region, string $code, int $deep): Collection
    {
        $children = new Collection();

        if ($region->code === $code) {
            if ($deep >= 0) {
                $children = $region->children;
                if ($deep > 0) {
                    foreach ($region->children as $child) {
                        $children = $children->merge($this->findChildrenRecursively($child, $code, $deep - 1));
                    }
                }
            }
        } else {
            foreach ($region->children as $child) {
                $children = $this->findChildrenRecursively($child, $code, $deep);
                if ($children->isNotEmpty()) {
                    break;
                }
            }
        }

        return $children;
    }

    /**
     * 查询并返回所有下级
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  RegionModel $region
     * @param  string      $code
     * @return Collection
     */
    protected function findAllChildrenRecursively(RegionModel $region, string $code): Collection
    {
        $children = new Collection();

        if ($region->code === $code) {
            $children = $region->children;
        } else {
            foreach ($region->children as $child) {
                $children = $this->findAllChildrenRecursively($child, $code);
                if ($children->isNotEmpty()) {
                    break;
                }
            }
        }

        return $children;
    }

}