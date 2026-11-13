<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Supported application locales.
     *
     * @var list<string>
     */
    protected array $locales = ['en', 'ru', 'tk'];

    /**
     * Switch current application locale and store preference in session.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (in_array($locale, $this->locales, true)) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
