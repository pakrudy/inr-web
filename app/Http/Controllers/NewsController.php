<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where('title', 'like', $searchTerm);
        }

        $posts = $query->paginate(10)->appends($request->only('search'));
        
        return view('news.index', compact('posts'));
    }
}