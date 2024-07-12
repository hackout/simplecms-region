<?php
namespace SimpleCMS\Region\Tests;

use SimpleCMS\Region\Packages\Region;

class QueryCheckTest extends \PHPUnit\Framework\TestCase
{
    public function testQueryCheck()
    {
        $bank = new Region(__DIR__ . '/../data/cities.json');

        $test = $bank->checkName('北京市');
        $this->assertIsBool($test);

        $test = $bank->checkName('北京');
        $this->assertIsBool($test);

        $test = $bank->checkCode('110000');
        $this->assertIsBool($test);

        $test = $bank->checkArea('010');
        $this->assertIsBool($test);

        $test = $bank->checkNumber('010-12345678');
        $this->assertIsBool($test);

        $test = $bank->checkNumber('01012345678');
        $this->assertIsBool($test);

        $test = $bank->checkZip('100000');
        $this->assertIsBool($test);
    }
}