<?php
namespace SimpleCMS\Region\Packages;


use Illuminate\Support\Collection;

/**
 * 地理模块
 */
class Region
{
    protected Collection $regions;

    protected FlattenRegion $flattenRegions;

    public function __construct(protected string $region_path)
    {
        $this->regions = new Collection();
        $this->loadRegions();
        $this->flattenRegions = new FlattenRegion($this->regions);
    }

    protected function loadRegions(): void
    {
        $content = file_get_contents(env('REGION_PATH', $this->region_path));
        try {
            $data = json_decode($content, true);
            foreach ($data as $region) {
                $_region = new RegionModel();
                $_region->setData($region);
                $this->regions->push($_region);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
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
            $children = (new ChildrenRecursively($region, $code))->getRegions();
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
        return $this->flattenRegions->contains(fn(RegionModel $region) => $region->checkName($name));
    }

    /**
     * 检查行政代码有效性
     *
     * @param string $code
     * @return bool
     */
    public function checkCode(string $code): bool
    {
        return $this->flattenRegions->contains(fn(RegionModel $region) => $region->checkCode($code));
    }

    /**
     * 检查区号有效性
     *
     * @param string $area
     * @return bool
     */
    public function checkArea(string $area): bool
    {
        return $this->flattenRegions->contains(fn(RegionModel $region) => $region->checkArea($area));
    }

    /**
     * 检查电话号码有效性
     *
     * @param string $number
     * @return bool
     */
    public function checkNumber(string $number): bool
    {
        return $this->flattenRegions->contains(fn(RegionModel $region) => $region->checkNumber($number));
    }

    /**
     * 检查邮编有效性
     *
     * @param string $zip
     * @return bool
     */
    public function checkZip(string $zip): bool
    {
        return $this->flattenRegions->contains(fn(RegionModel $region) => $region->checkZip($zip));
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
        return $this->flattenRegions->first(fn(RegionModel $region) => $region->code == $code);
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
            $children = (new ChildrenRecursively($region, $code, $deep))->getRegions();
            if ($children->isNotEmpty()) {
                break;
            }
        }

        return $children;
    }

}