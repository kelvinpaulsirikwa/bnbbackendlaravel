<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BnbRoom;
use App\Models\Motel;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\View\View;

class RoomController extends Controller
{
    use ResolvesImageUrls;

    public function show(Motel $motel, BnbRoom $room): View
    {
        // Check if motel is active - if not, abort with 404
        if ($motel->status !== 'active') {
            abort(404);
        }

        if ($room->motelid !== $motel->id) {
            abort(404);
        }

        $room->load([
            'roomType',
            'items',
            'images',
            'motel.details',
        ]);

        $gallery = collect([$room->frontimage])
            ->merge($room->images->pluck('imagepath'))
            ->filter()
            ->unique()
            ->map(fn ($path) => $this->resolveImageUrl($path))
            ->values();

        $items = $room->items->map(function ($item) {
            return [
                'name' => $item->name,
                'description' => $item->description,
            ];
        });

        $primaryImage = $this->resolveImageUrl(
            $room->frontimage
            ?? optional($room->images->first())->imagepath
        );

        return view('websitepages.rooms.show', [
            'room' => $room,
            'motel' => $motel,
            'gallery' => $gallery,
            'items' => $items,
            'primaryImage' => $primaryImage,
        ]);
    }
}

