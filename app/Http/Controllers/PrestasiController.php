<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasi::where('user_id', Auth::id())->latest()->paginate(10);

        return view('customer.prestasi.index', compact('prestasi'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $prestasi)
    {
        // Ensure the customer can only see their own achievement
        if ($prestasi->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.prestasi.show', compact('prestasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.prestasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_prestasi' => ['required', 'string', 'max:255'],
        ]);

        Prestasi::create([
            'user_id' => Auth::id(),
            'judul_prestasi' => $validated['judul_prestasi'],
            // status, validitas, etc. will use database defaults
        ]);

        return redirect()->route('dashboard')->with('success', 'Legacy berhasil diajukan dan sedang menunggu validasi.');
    }
}