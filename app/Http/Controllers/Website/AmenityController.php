<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Motel;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AmenityController extends Controller
{
    use ResolvesImageUrls;

    public function index(): View
    {
        $amenities = Amenity::query()
            ->orderBy('name')
            ->get()
            ->map(fn (Amenity $amenity) => $this->formatAmenity($amenity));

        return view('websitepages.amenities', [
            'amenities' => $amenities,
        ]);
    }

    public function show(Request $request, Amenity $amenity): View
    {
        $motelsQuery = Motel::with(['rooms', 'amenities.amenity', 'motelType', 'images'])
            ->withCount('rooms')
            ->whereHas('amenities', function ($query) use ($amenity) {
                $query->where('amenities_id', $amenity->id);
            });

        /** @var LengthAwarePaginator $motels */
        $motels = $motelsQuery->orderBy('name')->paginate(9);
        $motels->appends($request->query());

        $motels->getCollection()->transform(function (Motel $motel) {
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
                'type' => optional($motel->motelType)->name,
                'description' => Str::limit(strip_tags($motel->description ?? ''), 150),
                'image' => $primaryImage,
                'starting_price' => $startingPrice,
                'rooms_count' => $motel->rooms_count,
                'amenities' => $amenityHighlights,
            ];
        });

        return view('websitepages.amenities.show', [
            'amenity' => $this->formatAmenity($amenity),
            'motels' => $motels,
        ]);
    }

    protected function formatAmenity(Amenity $amenity): array
    {
        $rawIcon = $amenity->icon;
        $isImage = $rawIcon && (
            filter_var($rawIcon, FILTER_VALIDATE_URL)
            || Str::contains($rawIcon, ['.png', '.jpg', '.jpeg', '.svg', '/', '\\'])
        );

        return [
            'id' => $amenity->id,
            'name' => $amenity->name,
            'icon' => $isImage ? $this->resolveImageUrl($rawIcon) : $rawIcon,
            'icon_is_image' => $isImage,
        ];
    }
}

