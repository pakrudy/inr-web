<?php

namespace App\Http\Controllers;

use App\Models\Legacy;
use Illuminate\Http\Request;

class PublicLegacyController extends Controller
{
    public function index(Request $request)
    {
        $query = Legacy::with('user')->where('status', 'active');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        $legacies = $query->latest('published_at')->paginate(12)->appends($request->only('search'));

        return view('records.index', ['records' => $legacies]);
    }

    public function show(Legacy $legacy)
    {
        // Only show if active
        if ($legacy->status !== 'active') {
            abort(404);
        }

        return view('records.show', ['record' => $legacy]);
    }
}