# 中国地理信息

一个基于国家地理的地理信息表

## 环境配置要求

1. PHP 8.0+

## 自定义地理数据

在```.env```增加以下代码:

```bash
REGION_PATH='你的地理JSON位置' #绝对位置
```

## 使用方法

```php
use SimpleCMS\Region\Facades\Region; 
//获取所有城市
return Region::getAll();
//查询所有下级
return Region::getAllChildren(string $code = '行政标识');
//带深度查询
return Region::getChildren(string $code, int $deep = 0);
//坐标计算距离
distance($lat1,$lng1,$lat2,$lng2);
//SimpleCMS service
$service->distance($lat1,$lng1,$maxDistance,$latKey,$lngKey);
```

## 数据结构

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

## Facades

```php
use SimpleCMS\Region\Facades\Region; #地理位置 
```

## 其他说明

更多操作参考IDE提示
