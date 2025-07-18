<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'locale' => 'required|in:en,hi',
        ]);
        
        Session::put('locale', $request->locale);
        App::setLocale($request->locale);
        
        return back();
    }
}