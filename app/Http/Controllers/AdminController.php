<?php

namespace App\Http\Controllers;

use App\Models\LegacyUpgradeApplication;
use App\Models\RecommendationUpgradeApplication;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;

        // For payments awaiting confirmation
        $pendingLegacyUpgrades = Transaction::where('status', 'pending')
            ->where('transactionable_type', 'App\Models\Legacy')
            ->where('transaction_type', 'upgrade')
            ->with('transactionable', 'user')
            ->latest()
            ->get();
            
        $pendingRecommendationUpgrades = Transaction::where('status', 'pending')
            ->where('transactionable_type', 'App\Models\Recommendation')
            ->where('transaction_type', 'upgrade')
            ->with('transactionable', 'user')
            ->latest()
            ->get();

        // For applications awaiting review
        $pendingLegacyApplications = LegacyUpgradeApplication::where('status', 'pending')
            ->with('legacy', 'user', 'package')
            ->latest()
            ->get();
            
        $pendingRecommendationApplications = RecommendationUpgradeApplication::where('status', 'pending')
            ->with('recommendation', 'user', 'package')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'notifications', 
            'pendingLegacyUpgrades', 
            'pendingRecommendationUpgrades',
            'pendingLegacyApplications',
            'pendingRecommendationApplications'
        ));
    }
}
