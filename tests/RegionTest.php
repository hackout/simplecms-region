<?php

namespace SimpleCMS\Region\Tests;

use PHPUnit\Framework\TestCase;
use SimpleCMS\Region\Packages\Region;

class RegionTest extends TestCase
{
    public function testItLoadsBundledRegions(): void
    {
        $path = __DIR__ . '/../data/cities.json';
        $region = new Region($path);

        $this->assertGreaterThan(0, $region->getAll()->count());
        $this->assertSame('110000', $region->findRegion('110000')?->code);
        $this->assertSame('010', $region->findRegion('110000')?->area);
    }

    public function testItFindsChildren(): void
    {
        $path = __DIR__ . '/../data/cities.json';
        $region = new Region($path);

        $children = $region->getChildren('110000');
        $this->assertNotEmpty($children);
        $this->assertSame('110100', $children->first()->code);
    }
}
