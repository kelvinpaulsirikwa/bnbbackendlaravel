<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BnbAmenity;
use App\Models\Motel;
use App\Support\Concerns\ResolvesImageUrls;
use Illuminate\View\View;

class MotelAmenityController extends Controller
{
    use ResolvesImageUrls;

    public function index(Motel $motel): View
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $amenities */
        $amenities = BnbAmenity::with(['amenity', 'images'])
            ->where('bnb_motels_id', $motel->id)
            ->orderByDesc('created_at')
            ->paginate(6);

        $amenities->getCollection()->transform(function (BnbAmenity $amenity) {
            $images = $amenity->images
                ->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'url' => $this->resolveImageUrl($image->filepath),
                        'description' => $image->description,
                    ];
                })
                ->filter(fn ($image) => filled($image['url']))
                ->values();

            if ($images->isEmpty()) {
                $images->push([
                    'id' => null,
                    'url' => $this->resolveImageUrl(null),
                    'description' => 'Image coming soon',
                ]);
            }

            $primaryImage = data_get($images->first(), 'url', $this->resolveImageUrl(null));

            return [
                'id' => $amenity->id,
                'name' => optional($amenity->amenity)->name ?? 'Amenity',
                'amenity_id' => optional($amenity->amenity)->id,
                'description' => $amenity->description,
                'primary_image' => $primaryImage,
                'images' => $images->toArray(),
            ];
        });

        return view('websitepages.motels.amenities', [
            'motel' => $motel,
            'amenities' => $amenities,
        ]);
    }
}


