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
        View::share([
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
            ->whereHas('motel', function ($query) {
                $query->active();
            })
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(function (BnbImage $image) {
                return [
                    'motel_id' => optional($image->motel)->id,
                    'image_id' => $image->id,
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

        $spotlightMotels = Motel::active()
            ->with(['rooms', 'amenities.amenity', 'images', 'district.region'])
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

                $districtName = optional($motel->district)->name;
                $regionName = optional(optional($motel->district)->region)->name;
                $location = collect([$districtName, $regionName])->filter()->implode(' • ');

                return [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => Str::limit(strip_tags($motel->description ?? 'Thoughtfully hosted stays with bespoke service.')), 
                    'image' => $primaryImage,
                    'starting_price' => $startingPrice,
                    'amenities' => $amenityHighlights,
                    'location' => $location,
                ];
            });

        // Get statistics with caching (cache for 1 hour to improve performance)
        // Only count active motels for public statistics
        $statistics = Cache::remember('website_statistics', 3600, function () {
            return [
                'total_countries' => Country::count(),
                'total_regions' => Region::count(),
                'total_districts' => District::count(),
                'total_motels' => Motel::active()->count(),
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

    /**
     * Display the contact page.
     */
    public function contact(): ViewResponse
    {
        return view('websitepages.contact');
    }
}

