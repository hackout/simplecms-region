<?php

namespace SimpleCMS\Region;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Region\Services\DistanceService;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Region\Validation\Rule\RegionZipRule;
use SimpleCMS\Region\Validation\Rule\RegionAreaRule;
use SimpleCMS\Region\Validation\Rule\RegionCodeRule;
use SimpleCMS\Region\Validation\Rule\RegionNameRule;
use SimpleCMS\Region\Validation\Rule\RegionNumberRule;

class RegionServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadedValidator();
        $this->loadedHelpers();
        $this->loadFacades();
        $this->addService();
        $this->addMacro();
    }

    /**
     * 加载验证
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function loadedValidator(): void
    {
        Validator::extend(
            'region_area',
            RegionAreaRule::class
        );
        Validator::extend(
            'region_code',
            RegionCodeRule::class
        );
        Validator::extend(
            'region_name',
            RegionNameRule::class
        );
        Validator::extend(
            'region_number',
            RegionNumberRule::class
        );
        Validator::extend(
            'region_zip',
            RegionZipRule::class
        );
    }

    /**
     * 修改query
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function addMacro(): void
    {
        if (class_exists(SimpleService::class)) {
            SimpleService::macro('queryDistance', function (SimpleService $service, float $lat, float $lng, float $maxDistance = 50, string $geoColumn) {
                $distanceService = new DistanceService;
                return $distanceService->queryDistance($service, $lat, $lng, $maxDistance, $geoColumn);
            });
            SimpleService::macro('selectDistance', function (SimpleService $service, float $lat, float $lng, string $geoColumn, string $alias) {
                $distanceService = new DistanceService;
                return $distanceService->selectDistance($service, $lat, $lng, $geoColumn, $alias);
            });
        }
    }

    /**
     * 绑定自定义Service
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function addService(): void
    {
        if (class_exists(SimpleService::class)) {
            SimpleService::macro('queryDistance', function (SimpleService $service, float $lat, float $lng, float $maxDistance = 50, string $geoColumn) {
                $distanceService = new DistanceService;
                return $distanceService->queryDistance($service, $lat, $lng, $maxDistance, $geoColumn);
            });
            SimpleService::macro('selectDistance', function (SimpleService $service, float $lat, float $lng, string $geoColumn) {
                $distanceService = new DistanceService;
                return $distanceService->selectDistance($service, $lat, $lng, $geoColumn);
            });
        }
    }

    /**
     * 绑定Facades
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function loadFacades(): void
    {
        $this->app->bind('region', fn() => new \SimpleCMS\Region\Packages\Region(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '/data/cities.json'));
    }


    /**
     * 加载辅助函数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function loadedHelpers(): void
    {

        foreach (scandir(__DIR__ . DIRECTORY_SEPARATOR . 'helpers') as $helperFile) {
            $path = sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'helpers',
                DIRECTORY_SEPARATOR,
                $helperFile
            );

            if (!is_file($path)) {
                continue;
            }

            $function = Str::before($helperFile, '.php');

            if (function_exists($function)) {
                continue;
            }

            require_once $path;
        }
    }
}
