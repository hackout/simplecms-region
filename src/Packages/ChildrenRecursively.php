<?php
namespace SimpleCMS\Region\Packages;


use Illuminate\Support\Collection;

/**
 * 获取子级列表
 */
class ChildrenRecursively
{
    protected Collection $regions;

    public function __construct(RegionModel $region, string $code, int $deep = 0)
    {
        $this->regions = $this->loadRecursively($region, $code, $deep);
    }

    /**
     * 加载封装
     * @param \SimpleCMS\Region\Packages\RegionModel $region
     * @param string $code
     * @param int $deep
     * @return \Illuminate\Support\Collection
     */
    protected function loadRecursively(RegionModel $region, string $code, int $deep = 0):Collection
    {
        $regions  = new Collection();
        if ($region->code === $code) {
            $regions = $region->children;
            if ($deep > 0) {
                foreach ($region->children as $child) {
                    $regions = $regions->merge($this->loadRecursively($child, $code, $deep - 1));
                }
            }
        } else {
            foreach ($region->children as $child) {
                $regions = $this->loadRecursively($child, $code, $deep);
                if ($regions->isNotEmpty()) {
                    break;
                }
            }
        }
        return $regions;
    }

    /**
     * 获取列表
     * @return \Illuminate\Support\Collection
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }
}