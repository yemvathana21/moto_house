<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (!in_array($locale, ['en', 'km'])) {
            return response()->json(['message' => 'Invalid locale.'], 422);
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return response()->json([
            'locale' => $locale,
            'message' => 'Language switched successfully.',
        ]);
    }
}
