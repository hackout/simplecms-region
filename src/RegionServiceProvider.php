<?php

namespace SimpleCMS\Region;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Region\Services\DistanceService;

class RegionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadFacades();
        $this->addService();
    }

    protected function addService(): void
    {
        if (class_exists('SimpleCMS\Framework\Services\SimpleService')) {
            SimpleService::macro('queryDistance', function (float $lat, float $lng, float $maxDistance = 50, string $geoColumn) {
                $distanceService = new DistanceService;
                return $distanceService->queryDistance($lat, $lng, $maxDistance, $geoColumn);
            });
            SimpleService::macro('selectDistance', function (float $lat, float $lng, string $geoColumn) {
                $distanceService = new DistanceService;
                return $distanceService->selectDistance($lat, $lng, $geoColumn);
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
        $this->app->bind('region', fn() => new \SimpleCMS\Region\Packages\Region\Region(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '/data/cities.json'));
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
