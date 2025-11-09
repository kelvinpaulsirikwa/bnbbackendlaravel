<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\View\View;

class AmenityController extends Controller
{
    public function index(): View
    {
        $amenities = Amenity::query()
            ->orderBy('name')
            ->get()
            ->map(function (Amenity $amenity) {
                return [
                    'id' => $amenity->id,
                    'name' => $amenity->name,
                    'icon' => $amenity->icon,
                ];
            });

        return view('websitepages.amenities', [
            'amenities' => $amenities,
        ]);
    }
}

