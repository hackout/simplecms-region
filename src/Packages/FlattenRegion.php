<?php
namespace SimpleCMS\Region\Packages;


use Illuminate\Support\Collection;

/**
 * 地理信息平铺
 */
class FlattenRegion
{
    protected Collection $regions;

    public function __construct(Collection $regions)
    {
        $this->regions = new Collection();
        $this->setFlatten($regions);
    }

    protected function setFlatten(Collection $regions)
    {
        $regions->each(function (RegionModel $region) {
            $this->regions->add($this->flatten($region));
        });
        $this->regions = $this->regions->flatten(5);
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
     * Determine if an item exists in the collection.
     *
     * @param  mixed  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return bool
     */
    public function contains($key, $operator = null, $value = null)
    {
        return $this->regions->contains($key, $operator, $value);
    }

    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param  ?callable  $callback
     * @param  ?mixed  $default
     * @return mixed
     */
    public function first(?callable $callback = null, $default = null)
    {
        return $this->regions->first($callback, $default);
    }
}