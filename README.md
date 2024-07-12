# SimpleCMS/Laravel Region Component

📦 A SimpleCMS/Laravel component for Chinese national geographic information based on information published by the National Bureau of Statistics. 

English | [简体中文](./README_zhCN.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/region/v/stable.svg)](https://packagist.org/packages/simplecms/region) [![Latest Unstable Version](https://poser.pugx.org/simplecms/region/v/unstable.svg)](https://packagist.org/packages/simplecms/region) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-region/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/region/downloads)](https://packagist.org/packages/simplecms/region) [![License](https://poser.pugx.org/simplecms/region/license)](https://packagist.org/packages/simplecms/region)

## Requirements

- PHP >= 8.0
- MySql >= 5.7
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) >= 9.0

## Installation

```bash
composer require simplecms/region
```

## Usage

Includes a distance method.

### Get Geographic List

```php
use SimpleCMS\Region\Facades\Region; 
Region::getAll(); // Returns the complete list
```

### Query and Check

```php
use SimpleCMS\Region\Facades\Region; 
Region::findRegion(string $code = 'Administrative Identifier'); // Query geographic information
Region::getAllChildren(string $code = 'Administrative Identifier'); // Query all children
Region::getChildren(string $code, int $deep = 0); // Query down with depth
Region::checkName(string $name); // Check name validity
Region::checkCode(string $code); // Check validity of administrative code
Region::checkArea(string $area); // Check area code validity
Region::checkNumber(string $number); // Check phone number validity
Region::checkZip(string $zip); // Check zip code validity supports full zip code
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
distance($lat1,$lng1,$lat2,$lng2); // Calculate distance between two locations
```

### Validation

```php
$rules = [
    'region' => 'region_code', // Check administrative code
    'region_name' => 'region_name', // Check geographic name
    'region_zip' => 'region_zip', // Check zip code
    'region_area' => 'region_area', // Check area code
    'region_number' => 'region_number', // Check phone number (landline with area code)
];
$messages = [
    'region.region_code' => 'Incorrect administrative code',
    'region_name.region_name' => 'Incorrect geographic name',
    'region_zip.region_zip' => 'Incorrect zip code',
    'region_area.region_area' => 'Incorrect area code',
    'region_number.region_number' => 'Incorrect area code',
];
$data = $request->validate($rules,$messages);
```

## Custom Geographic Data

You can customize your own data using the ```.env``` file.

### Modify Configuration File Path

Add the following code to the ```.env``` file:

```bash
BANK_PATH='Your Geographic JSON file address' #Absolute location
```

### JSON Data Format

The data structure should follow the format below:

```bash
{
    "name": "Name",
    "short": "Abbreviation/Short Name",
    "code": "Unique Geographic Identifier",
    "area": "Area Code",
    "zip": "Postal Code",
    "lng": 100.00000, #Longitude
    "lat": 32.00000, #Latitude
    "children": [
        ....#Same structure as above
    ]
}
```

## SimpleCMS Extension

Please load ```simplecms/framework``` first.

### Service Calls

```php
use SimpleService;
// Get distance
$service->selectDistance(float $lat = 23.23211, float $lng = 111.23123,string $column = 'location');
// Query by record
$service->queryDistance(float $lat = 23.23211, float $lng = 111.23123, float $maxDistance = 50,string $column = 'location')
```

## License

MIT
