<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationUpgradeApplication;
use App\Notifications\UpgradeApplicationRejected;
// use App\Notifications\RecommendationUpgradeApplicationApproved; // TODO: Create this notification
use Illuminate\Http\Request;

class RecommendationUpgradeApplicationController extends Controller
{
    public function index()
    {
        $applications = RecommendationUpgradeApplication::with(['user', 'recommendation', 'package'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);
            
        return view('admin.recommendation-upgrades.index', compact('applications'));
    }

    public function show(RecommendationUpgradeApplication $application)
    {
        $application->load(['user', 'recommendation', 'package']);
        return view('admin.recommendation-upgrades.show', compact('application'));
    }

    public function approve(RecommendationUpgradeApplication $application)
    {
        $application->update(['status' => 'awaiting_payment']);

        // TODO: Notify the user
        // $application->user->notify(new RecommendationUpgradeApplicationApproved($application));

        return redirect()->back()->with('success', 'Application approved. User has been notified to make a payment.');
    }

    public function reject(RecommendationUpgradeApplication $application)
    {
        $application->update(['status' => 'rejected']);

        // Notify the user of the rejection
        $application->user->notify(new UpgradeApplicationRejected($application));

        return redirect()->back()->with('success', 'Application has been rejected.');
    }
}