<?php

namespace App\Providers;

use App\Models\Amenity;
use App\Models\Country;
use App\Models\MotelType;
use App\Models\Region;
use App\Models\RoomType;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
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
        // Use vendor pagination view for admin and owner routes
        if (Request::is('adminpages*') || Request::is('bnbowner*')) {
            Paginator::defaultView('layouts.vendor.pagination.bootstrap-5');
        }

        View::share('admin_can', function (string $permission): bool {
            $user = Auth::user();
            if (!$user || $user->role !== 'bnbadmin') {
                return false;
            }
            $permissions = $user->admin_permissions;
            if ($permissions === null || (is_array($permissions) && count($permissions) === 0)) {
                return true;
            }
            return in_array($permission, $permissions, true);
        });

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

        View::composer('websitepages.layouts.app', function ($view) {
            $navMotelTypes = Cache::remember('nav_motel_types', 3600, function () {
                return MotelType::query()
                    ->orderBy('name')
                    ->get(['id', 'name']);
            });

            $navAmenities = Cache::remember('nav_amenities', 3600, function () {
                return Amenity::query()
                    ->orderBy('name')
                    ->get(['id', 'name']);
            });

            $view->with([
                'navMotelTypes' => $navMotelTypes,
                'navAmenities' => $navAmenities,
            ]);
        });
    }
}
