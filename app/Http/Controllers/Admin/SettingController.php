<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_legacy_initial' => 'required|numeric|min:0',
            'payment_recommendation_initial' => 'required|numeric|min:0',
            'payment_recommendation_upgrade' => 'required|numeric|min:0',
            'payment_recommendation_renewal' => 'required|numeric|min:0',
            'payment_recommendation_renewal_indexed' => 'required|numeric|min:0',
        ]);

        foreach ($validated as $key => $value) {
            $dbKey = '';
            if ($key === 'payment_recommendation_renewal_indexed') {
                $dbKey = 'payment.recommendation.renewal_indexed';
            } else {
                // The keys in the form are submitted with underscores, but stored with dots.
                $dbKey = str_replace('_', '.', $key);
            }
            
            Setting::updateOrCreate(
                ['key' => $dbKey],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
