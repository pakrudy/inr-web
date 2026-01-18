<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;

class PublicRecommendationController extends Controller
{
    public function index(Request $request)
    {
        $query = Recommendation::with('user')->where('status', 'active');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('place_name', 'like', $searchTerm)
                    ->orWhere('address', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        $recommendations = $query->latest('published_at')->paginate(12)->appends($request->only('search'));

        return view('recommendations.index', compact('recommendations'));
    }

    public function show(Recommendation $recommendation)
    {
        // Only show if active
        if ($recommendation->status !== 'active') {
            abort(404);
        }

        return view('recommendations.show', compact('recommendation'));
    }
}