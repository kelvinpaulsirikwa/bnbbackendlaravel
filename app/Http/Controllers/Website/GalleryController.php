<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BnbImage;
use App\Models\Motel;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class GalleryController extends Controller
{
    use ResolvesImageUrls;

    public function index(Request $request): View
    {
        /** @var LengthAwarePaginator $images */
        $images = BnbImage::with('motel')
            ->whereHas('motel')
            ->orderByDesc('created_at')
            ->paginate(12);

        $images->getCollection()->transform(function (BnbImage $image) {
            $motel = $image->motel;

            return [
                'id' => $image->id,
                'motel_id' => optional($motel)->id,
                'motel_name' => optional($motel)->name ?? 'Unnamed motel',
                'url' => $this->resolveImageUrl($image->filepath),
                'created_at' => $image->created_at,
            ];
        });

        return view('websitepages.gallery', [
            'images' => $images,
        ]);
    }

    public function motelGallery(Motel $motel): View
    {
        $motel->load('images');
        
        $gallery = collect([$motel->front_image])
            ->merge($motel->images->pluck('filepath'))
            ->filter()
            ->unique()
            ->map(fn ($path) => $this->resolveImageUrl($path))
            ->values();

        return view('websitepages.motels.gallery', [
            'motel' => $motel,
            'gallery' => $gallery,
        ]);
    }
}

