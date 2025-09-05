<?php

namespace App\Http\Controllers;

use App\Models\AppItem;
use Illuminate\Http\Request;

class AppController extends Controller
{
    // Public listing (web)
    public function index()
    {
        $apps = AppItem::orderBy('created_at','desc')->get();
        return view('home', compact('apps'));
    }

    // API endpoint for JSON
    public function apiIndex()
    {
        $apps = AppItem::orderBy('created_at','desc')->get();
        return response()->json(['data' => $apps]);
    }

    // Public detail (optional)
    public function show($id)
    {
        $app = AppItem::findOrFail($id);
        return view('apps.show', compact('app'));
    }
}
