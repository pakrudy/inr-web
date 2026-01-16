<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    /**
     * Show the form for creating a new recommendation request.
     */
    public function createRekomendasi()
    {
        $eligiblePrestasi = Prestasi::where('user_id', Auth::id())
            ->where('validitas', 'valid')
            ->where('rekomendasi', false)
            ->get();

        return view('customer.prestasi.rekomendasi.create', compact('eligiblePrestasi'));
    }

    /**
     * Store a newly created recommendation request in storage.
     */
    public function storeRekomendasi(Request $request)
    {
        $validated = $request->validate([
            'prestasi_id' => [
                'required',
                Rule::exists('prestasi')->where(function ($query) {
                    $query->where('user_id', Auth::id())
                          ->where('validitas', 'valid')
                          ->where('rekomendasi', false);
                }),
            ],
        ], [
            'prestasi_id.required' => 'Anda harus memilih salah satu prestasi.',
            'prestasi_id.exists' => 'Prestasi yang dipilih tidak valid atau sudah pernah diajukan untuk rekomendasi.',
        ]);

        $prestasi = Prestasi::find($validated['prestasi_id']);
        $prestasi->update([
            'rekomendasi' => true,
        ]);

        return redirect()->route('customer.prestasi.index')->with('success', 'Pengajuan rekomendasi untuk prestasi "' . $prestasi->judul_prestasi . '" telah berhasil dikirim.');
    }
}