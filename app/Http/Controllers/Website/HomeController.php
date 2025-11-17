<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\BnbImage;
use App\Models\Country;
use App\Models\MotelType;
use App\Models\Region;
use App\Models\RoomType;
use App\Models\Motel;
use App\Models\District;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View as ViewResponse;

class HomeController extends Controller
{
    use ResolvesImageUrls;

    public function __construct()
    {
        $footerMotelTypes = MotelType::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $footerRegions = Region::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $footerCountries = Country::query()
            ->orderBy('name')
            ->pluck('name');

        $footerRoomTypes = RoomType::query()
            ->orderBy('name')
            ->pluck('name');

        View::share([
            'footerMotelTypes' => $footerMotelTypes,
            'footerRegions' => $footerRegions,
            'footerCountries' => $footerCountries,
            'footerRoomTypes' => $footerRoomTypes,
            'companyInfo' => config('companyinfo'),
        ]);
    }

    /**
     * Clear the cached website statistics.
     * Call this method when countries, regions, districts, motels, or customers are created/updated/deleted.
     */
    public static function clearStatisticsCache(): void
    {
        Cache::forget('website_statistics');
    }

    /**
     * Display the public landing page.
     */
    public function index(): ViewResponse
    {
        $propertyTypes = MotelType::query()
            ->orderBy('name')
            ->get()
            ->map(function (MotelType $type) {
                

                return [
                    'id' => $type->id,
                    'name' => $type->name,
                ];
            });

        $featuredGallery = BnbImage::with('motel')
            ->whereHas('motel')
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(function (BnbImage $image) {
                return [
                    'id' => $image->id,
                    'motel_name' => $image->motel->name ?? 'Unnamed motel',
                    'url' => $this->resolveImageUrl($image->filepath),
                ];
            });

        $featuredAmenities = Amenity::query()
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->map(function (Amenity $amenity) {
                $rawIcon = $amenity->icon;
                $isImage = $rawIcon && (
                    filter_var($rawIcon, FILTER_VALIDATE_URL)
                    || Str::contains($rawIcon, ['.png', '.jpg', '.jpeg', '.svg', '/'])
                );

                return [
                    'id' => $amenity->id,
                    'name' => $amenity->name,
                    'icon' => $isImage ? $this->resolveImageUrl($rawIcon) : $rawIcon,
                    'icon_is_image' => $isImage,
                ];
            });

        $spotlightMotels = Motel::with(['rooms', 'amenities.amenity', 'images'])
            ->withCount('rooms')
            ->inRandomOrder()
            ->take(15)
            ->get()
            ->map(function (Motel $motel) {
                $primaryImage = $this->resolveImageUrl(
                    $motel->front_image
                    ?? optional($motel->images->first())->filepath
                    ?? optional($motel->rooms->first())->frontimage
                );

                $startingPrice = $motel->rooms->min('price_per_night');
                $amenityHighlights = $motel->amenities
                    ->map(fn ($pivot) => optional($pivot->amenity)->name)
                    ->filter()
                    ->take(3)
                    ->values();

                return [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => Str::limit(strip_tags($motel->description ?? 'Thoughtfully hosted stays with bespoke service.')), 
                    'image' => $primaryImage,
                    'starting_price' => $startingPrice,
                    'amenities' => $amenityHighlights,
                ];
            });

        // Get statistics with caching (cache for 1 hour to improve performance)
        $statistics = Cache::remember('website_statistics', 3600, function () {
            return [
                'total_countries' => Country::count(),
                'total_regions' => Region::count(),
                'total_districts' => District::count(),
                'total_motels' => Motel::count(),
                'total_customers' => Customer::count(),
            ];
        });

        return view('websitepages.home', [
            'propertyTypes' => $propertyTypes,
            'featuredGallery' => $featuredGallery,
            'featuredAmenities' => $featuredAmenities,
            'spotlightMotels' => $spotlightMotels,
            'statistics' => $statistics,
        ]);
    }

    /**
     * Display the services page.
     */
    public function services(): ViewResponse
    {
        // Get all BNB types (MotelTypes)
        $bnbTypes = MotelType::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        // Get all Room types
        $roomTypes = RoomType::query()
            ->orderBy('name')
            ->get(['id', 'name', 'description']);

        // Get countries with their regions and districts (hierarchical)
        $countries = Country::with(['regions.districts'])
            ->orderBy('name')
            ->get()
            ->map(function (Country $country) {
                return [
                    'id' => $country->id,
                    'name' => $country->name,
                    'regions' => $country->regions->map(function ($region) {
                        return [
                            'id' => $region->id,
                            'name' => $region->name,
                            'districts' => $region->districts->map(function ($district) {
                                return [
                                    'id' => $district->id,
                                    'name' => $district->name,
                                ];
                            })->values(),
                        ];
                    })->values(),
                ];
            });

        return view('websitepages.services', [
            'bnbTypes' => $bnbTypes,
            'roomTypes' => $roomTypes,
            'countries' => $countries,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact(): ViewResponse
    {
        return view('websitepages.contact');
    }
}

