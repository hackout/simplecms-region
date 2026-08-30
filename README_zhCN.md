# SimpleCMS/Laravel Region组件

📦 一个根据国家统计局公布信息写的中国国家地理信息SimpleCMS/Laravel组件

简体中文 | [English](./README.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/region/v/stable.svg)](https://packagist.org/packages/simplecms/region) [![Latest Unstable Version](https://poser.pugx.org/simplecms/region/v/unstable.svg)](https://packagist.org/packages/simplecms/region) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-region/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/region/downloads)](https://packagist.org/packages/simplecms/region) [![License](https://poser.pugx.org/simplecms/region/license)](https://packagist.org/packages/simplecms/region)

## 环境需求

- PHP >= 8.2
- MySql >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) >= 11.0

## 安装

```bash
composer require simplecms/region
```

## 使用方法

内置了distance方法。

### Model模型使用

使用```RegionTrait```对模型进行关联

```php
use \SimpleCMS\Region\Traits\RegionTrait;
```

模型会自动关联上```region```这个morphOne关系

#### SCOPE

查询模型attributes值

```php
$query->withGeoDistance(23.9999,133.9999,10000);
```

### Facade

```php
use SimpleCMS\Region\Facades\Region; 


Region::getAll(); //返回完整列表
Region::findRegion(string $code = '行政标识'); //查询地理信息
Region::getAllChildren(string $code = '行政标识'); // 查询所有下级
Region::getChildren(string $code, int $deep = 0); // 带深度向下查询
Region::checkName(string $name); // 检查名称有效性
Region::checkCode(string $code); // 检查行政代码有效性
Region::checkArea(string $area); // 检查区号有效性
Region::checkNumber(string $number); // 检查电话号码有效性
Region::checkZip(string $zip); // 检查邮编有效性 支持完整邮编
```

### Laravel Model Casts

```php
use SimpleCMS\Region\Casts\Point; 
use SimpleCMS\Region\Casts\LineString; 
use SimpleCMS\Region\Casts\Polygon; 

public $casts = [
    'geo' => Point::class,
    'geo' => LineString::class,
    'geo' => Polygon::class
];
```

### Helpers

```php

distance($lat1,$lng1,$lat2,$lng2); // 计算两地距离

```

### Validation

```php
$rules = [
    'region' => 'region_code', //检查行政代码
    'region_name' => 'region_name', //检查地理名称
    'region_zip' => 'region_zip', //检查邮编
    'region_area' => 'region_area', //检查电话区号
    'region_number' => 'region_number', //检查电话号码(座机带区号)
];
$messages = [
    'region.region_code' => '行政代码不正确',
    'region_name.region_name' => '地理名称不正确',
    'region_zip.region_zip' => '邮编不正确',
    'region_area.region_area' => '区号不正确',
    'region_number.region_number' => '区号不正确',
];
$data = $request->validate($rules,$messages);
```

## 自定义地理数据

你可以通过```.env```自定义自己的数据。

### 修改配置文件路径

在```.env```增加以下代码:

```bash
REGION_PATH='你的地理JSON文件地址' # 绝对位置
# 或兼容旧配置
BANK_PATH='你的地理JSON文件地址' # 绝对位置
```

### JSON数据格式

数据结构参考遵循以下格式:

```bash
{
    "name": "名称",
    "short": "缩写/简称/短名",
    "code": "唯一地理标识",
    "area": "电话区号",
    "zip": "邮政编码",
    "lng": 100.00000, #经度
    "lat": 32.00000, #纬度
    "children": [
        ....#跟上面结构一样
    ]
}
```

## SimpleCMS扩展

请先加载```simplecms/framework```

### 服务调用

```php
use SimpleService;

//获取距离
$service->selectDistance(float $lat = 23.23211, float $lng = 111.23123,string $column = 'location');
//通过记录查询
$service->queryDistance(float $lat = 23.23211, float $lng = 111.23123, float $maxDistance = 50,string $column = 'location')
```

## License

MIT
