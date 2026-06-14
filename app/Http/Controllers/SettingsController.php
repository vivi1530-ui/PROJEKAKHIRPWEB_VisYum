<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $theme = $request->input('theme', 'light');
        $fontSize = $request->input('font_size', 'medium');

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil disimpan!',
            'data' => [
                'theme' => $theme,
                'font_size' => $fontSize
            ]
        ])->cookie('theme', $theme, 60*24*7, null, null, false, false)
          ->cookie('font_size', $fontSize, 60*24*7, null, null, false, false);
    }
}