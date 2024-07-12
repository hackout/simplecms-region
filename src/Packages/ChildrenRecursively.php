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
        $this->regions = new Collection();
        $this->loadRecursively($region, $code, $deep);
    }

    protected function loadRecursively(RegionModel $region, string $code, int $deep = 0)
    {
        if ($region->code === $code) {
            $this->regions = $region->children;
            if ($deep > 0) {
                foreach ($region->children as $child) {
                    $this->regions = $this->regions->merge($this->loadRecursively($child, $code, $deep - 1));
                }
            }
        } else {
            foreach ($region->children as $child) {
                $this->regions = $this->loadRecursively($child, $code, $deep);
                if ($this->regions->isNotEmpty()) {
                    break;
                }
            }
        }
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