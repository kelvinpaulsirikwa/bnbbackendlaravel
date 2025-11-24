<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * @var array<string>
     */
    protected array $availableLocales = ['en', 'sw'];

    /**
     * Update the website locale for the current visitor.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $locale = strtolower($locale);

        if (! in_array($locale, $this->availableLocales, true)) {
            $locale = config('app.locale');
        }

        $request->session()->put('website_locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}

