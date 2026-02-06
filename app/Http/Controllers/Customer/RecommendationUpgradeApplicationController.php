<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\RecommendationUpgradeApplication;
use App\Models\RecommendationUpgradePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationUpgradeApplicationController extends Controller
{
    public function selectPackage(Recommendation $recommendation)
    {
        // TODO: Add authorization check to ensure the user owns the recommendation
        // TODO: Add check to ensure the recommendation is eligible for upgrade (e.g., status is 'active')

        $packages = RecommendationUpgradePackage::where('is_active', true)->get();

        return view('customer.recommendations.upgrade.select-package', compact('recommendation', 'packages'));
    }

    public function showApplicationForm(Recommendation $recommendation, $package_slug)
    {
        $package = RecommendationUpgradePackage::where('slug', $package_slug)->firstOrFail();
        if (is_string($package->features)) {
            $package->features = json_decode($package->features, true);
        }
        return view('customer.recommendations.upgrade.apply', compact('recommendation', 'package'));
    }

    public function storeApplication(Request $request, Recommendation $recommendation, $package_slug)
    {
        $package = RecommendationUpgradePackage::where('slug', $package_slug)->firstOrFail();
        if (is_string($package->features)) {
            $package->features = json_decode($package->features, true);
        }

        // Basic validation, can be expanded
        $validated = $request->validate([
            'form_data' => 'required|array',
        ]);

        // Prevent duplicate pending applications
        $existingApplication = RecommendationUpgradeApplication::where('recommendation_id', $recommendation->id)
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return redirect()->route('customer.recommendations.index')->with('error', 'You already have a pending upgrade application for this recommendation.');
        }

        RecommendationUpgradeApplication::create([
            'user_id' => Auth::id(),
            'recommendation_id' => $recommendation->id,
            'recommendation_upgrade_package_id' => $package->id,
            'status' => 'pending',
            'form_data' => $validated['form_data'],
        ]);

        return redirect()->route('customer.recommendations.index')->with('success', 'Your upgrade application has been submitted and is awaiting review.');
    }
}