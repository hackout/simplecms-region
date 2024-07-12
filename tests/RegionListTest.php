<?php
namespace SimpleCMS\Region\Tests;

use SimpleCMS\Region\Packages\Region;

class RegionListTest extends \PHPUnit\Framework\TestCase
{
    public function testRegionList()
    {
        $bank = new Region(__DIR__ . '/../data/cities.json');

        $list = $bank->getAll();
        $this->assertIsObject($list);

        $all = $bank->getAllChildren('010');
        $this->assertIsObject($all);

        $children = $bank->getChildren('010', 1);
        $this->assertIsObject($children);
    }
}