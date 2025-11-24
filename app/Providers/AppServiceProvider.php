<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\MotelType;
use App\Models\Region;
use App\Models\RoomType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('websitepages.components.footer', function ($view) {
            $footerData = Cache::remember('footer_data_lookup', 3600, function () {
                return [
                    'footerMotelTypes' => MotelType::query()
                        ->orderBy('name')
                        ->get(['id', 'name']),
                    'footerRegions' => Region::query()
                        ->orderBy('name')
                        ->get(['id', 'name']),
                    'footerCountries' => Country::query()
                        ->orderBy('name')
                        ->pluck('name'),
                    'footerRoomTypes' => RoomType::query()
                        ->orderBy('name')
                        ->get(['id', 'name']),
                    'companyInfo' => config('companyinfo'),
                ];
            });

            $view->with($footerData);
        });
    }
}
