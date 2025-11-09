<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BnbImage;
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
            return [
                'id' => $image->id,
                'motel_name' => $image->motel->name ?? 'Unnamed motel',
                'url' => $this->resolveImageUrl($image->filepath),
                'created_at' => $image->created_at,
            ];
        });

        return view('websitepages.gallery', [
            'images' => $images,
        ]);
    }
}

