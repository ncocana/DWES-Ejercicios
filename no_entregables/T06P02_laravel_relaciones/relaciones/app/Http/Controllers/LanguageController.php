<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function languageSwitch(Request $request)
    {
        // Get the language from the form
        $language = $request->input('language');

        // Store the language in the session
        // session(['language' => $language]);

        // Save the language in the user's record
        Auth::user()->update(['language' => $language]);

        return redirect()->back()->with(['language_switched' => $language]);
    }
}
