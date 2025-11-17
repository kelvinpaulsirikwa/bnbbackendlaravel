<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use App\Models\BnbRoom;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MotelController extends Controller
{
    use ResolvesImageUrls;

    public function index(Request $request): View
    {
        $query = Motel::with(['rooms', 'amenities.amenity', 'motelType', 'images'])
            ->withCount('rooms');

        if ($request->filled('region')) {
            $query->whereHas('district.region', function ($q) use ($request) {
                $q->where('id', $request->input('region'));
            });
        }

        if ($request->filled('motel_type')) {
            $query->where('motel_type_id', $request->input('motel_type'));
        }

        /** @var LengthAwarePaginator $motels */
        $motels = $query->orderBy('name')->paginate(9);
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

        return view('websitepages.motels.index', [
            'motels' => $motels,
        ]);
    }

    public function show(Motel $motel): View
    {
        $motel->load([
            'rooms.roomType',
            'rooms.items',
            'rooms.images',
            'amenities.amenity',
            'details',
            'district.region.country',
            'motelType',
            'images',
        ]);
        $motel->loadCount('rooms');

        $primaryImage = $this->resolveImageUrl(
            $motel->front_image
            ?? optional($motel->images->first())->filepath
        );

        $gallery = collect([$motel->front_image])
            ->merge($motel->images->pluck('filepath'))
            ->filter()
            ->unique()
            ->map(fn ($path) => $this->resolveImageUrl($path))
            ->values();

        $amenities = $motel->amenities
            ->map(function ($pivot) {
                return [
                    'amenity_id' => optional($pivot->amenity)->id,
                    'name' => optional($pivot->amenity)->name ?? 'Amenity',
                    'description' => $pivot->description,
                ];
            })
            ->filter(fn ($amenity) => filled($amenity['name']))
            ->values();

        $rooms = $motel->rooms
            ->map(function (BnbRoom $room) {
                $image = $this->resolveImageUrl(
                    $room->frontimage
                    ?? optional($room->images->first())->imagepath
                );

                $items = $room->items->map(fn ($item) => $item->name)->filter()->take(3);

                return [
                    'id' => $room->id,
                    'name' => optional($room->roomType)->name ?? 'Room '.$room->room_number,
                    'room_number' => $room->room_number,
                    'price' => $room->price_per_night,
                    'image' => $image,
                    'items' => $items,
                    'description' => optional($room->roomType)->description,
                ];
            })
            ->values();

        $location = optional($motel->district)->name;
        $region = optional(optional($motel->district)->region)->name;
        $country = optional(optional(optional($motel->district)->region)->country)->name;

        return view('websitepages.motels.show', [
            'motel' => $motel,
            'primaryImage' => $primaryImage,
            'gallery' => $gallery,
            'amenities' => $amenities,
            'rooms' => $rooms,
            'location' => collect([$location, $region, $country])->filter()->implode(', '),
        ]);
    }
}

