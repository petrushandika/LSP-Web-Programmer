<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Setting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        // Get published catalogues with user relationship
        $catalogues = Catalogue::where('status_publish', 'Y')
            ->with('user')
            ->latest()
            ->take(6) // Show only 6 latest catalogues on landing page
            ->get();

        // Get website settings
        $settings = Setting::first();

        return view('client.landing', compact('catalogues', 'settings'));
    }

    /**
     * Show catalogue detail page
     */
    public function catalogueDetail($id)
    {
        $catalogue = Catalogue::with('user')->where('catalogue_id', $id)->firstOrFail();
        $settings = Setting::first();
        
        return view('client.catalogue-detail', compact('catalogue', 'settings'));
    }
}