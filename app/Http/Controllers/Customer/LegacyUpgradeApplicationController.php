<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Legacy;
use App\Models\LegacyUpgradeApplication;
use App\Models\UpgradePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LegacyUpgradeApplicationController extends Controller
{
    public function selectPackage(Legacy $legacy)
    {
        $packages = UpgradePackage::where('is_active', true)->get();

        return view('customer.legacies.upgrade.select-package', compact('legacy', 'packages'));
    }

    public function showApplicationForm(Legacy $legacy, $package_slug)
    {
        $package = UpgradePackage::where('slug', $package_slug)->firstOrFail();
        if (is_string($package->features)) {
            $package->features = json_decode($package->features, true);
        }
        return view('customer.legacies.upgrade.apply', compact('legacy', 'package'));
    }

    public function storeApplication(Request $request, Legacy $legacy, $package_slug)
    {
        $package = UpgradePackage::where('slug', $package_slug)->firstOrFail();
        if (is_string($package->features)) {
            $package->features = json_decode($package->features, true);
        }

        // Basic validation, can be expanded
        $validated = $request->validate([
            'form_data' => 'required|array',
        ]);

        // Prevent duplicate pending applications
        $existingApplication = LegacyUpgradeApplication::where('legacy_id', $legacy->id)
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return redirect()->route('customer.legacies.index')->with('error', 'You already have a pending upgrade application for this legacy.');
        }

        LegacyUpgradeApplication::create([
            'user_id' => Auth::id(),
            'legacy_id' => $legacy->id,
            'upgrade_package_id' => $package->id,
            'status' => 'pending',
            'form_data' => $validated['form_data'],
        ]);

        return redirect()->route('customer.legacies.index')->with('success', 'Your upgrade application has been submitted and is awaiting review.');
    }
}
