<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegacyUpgradeApplication;
use App\Notifications\UpgradeApplicationApproved;
use Illuminate\Http\Request;

class LegacyUpgradeApplicationController extends Controller
{
    public function index()
    {
        $applications = LegacyUpgradeApplication::with(['user', 'legacy', 'package'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);
            
        return view('admin.legacy-upgrades.index', compact('applications'));
    }

    public function show(LegacyUpgradeApplication $application)
    {
        $application->load(['user', 'legacy', 'package']);
        return view('admin.legacy-upgrades.show', compact('application'));
    }

    public function approve(LegacyUpgradeApplication $application)
    {
        $application->update(['status' => 'awaiting_payment']);

        // Notify the user
        $application->user->notify(new UpgradeApplicationApproved($application));

        return redirect()->back()->with('success', 'Application approved. User has been notified to make a payment.');
    }

    public function reject(LegacyUpgradeApplication $application)
    {
        $application->update(['status' => 'rejected']);

        // TODO: Add notification to user

        return redirect()->back()->with('success', 'Application has been rejected.');
    }
}
