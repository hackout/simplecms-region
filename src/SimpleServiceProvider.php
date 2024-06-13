<?php

namespace SimpleCMS\Region;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Region\Services\DistanceService;

class SimpleServiceProvider extends ServiceProvider
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

    protected function addService():void
    {
        if(class_exists('SimpleCMS\Framework\Services\SimpleService'))
        {
            SimpleService::macro('distance', function(SimpleService $service,float $lat,float $lng,float $maxDistance = 50,$latKey = 'lat',$lngKey = 'lng') {
                $distanceService = new DistanceService($latKey,$lngKey);
                return $distanceService->queryDistance($service,$lat,$lng,$maxDistance);
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
        $this->app->bind('region', \SimpleCMS\Region\Packages\Region\Region::class);
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
