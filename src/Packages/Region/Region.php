<?php
namespace SimpleCMS\Region\Packages\Region;


use Illuminate\Support\Collection;

class Region
{
    protected Collection $regions;

    public function __construct(protected string $region_path)
    {

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

    protected function convertRegion(array $region): RegionModel
    {
        $obj = new RegionModel();
        $obj->name = array_key_exists('name', $region) && $region['name'] ? trim($region['name']) : null;
        $obj->short = array_key_exists('short', $region) && $region['short'] ? trim($region['short']) : null;
        $obj->code = array_key_exists('code', $region) && $region['code'] ? trim($region['code']) : null;
        $obj->area = array_key_exists('area', $region) && $region['area'] ? trim($region['area']) : null;
        $obj->zip = array_key_exists('zip', $region) && $region['zip'] ? trim($region['zip']) : null;
        $obj->lng = array_key_exists('lng', $region) && $region['lng'] ? trim($region['lng']) : null;
        $obj->lat = array_key_exists('lat', $region) && $region['lat'] ? trim($region['lat']) : null;
        if (array_key_exists('children', $region) && $region['children']) {
            foreach ($region['children'] as $child) {
                $obj->children->push($this->convertRegion($child));
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
        $this->loadRegions();
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
        $this->loadRegions();

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
     * 获取下级城市
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string     $code 地理标识
     * @param  int        $deep  返回携带子级深度，0 标识无children
     * @return Collection
     */
    public function getChildren(string $code, int $deep = 0): Collection
    {
        $this->loadRegions();

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