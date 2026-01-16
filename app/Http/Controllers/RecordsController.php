<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::with('user')
            ->where('status_prestasi', 'aktif');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_prestasi', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('nama_lengkap', 'like', $searchTerm);
                    });
            });
        }

        $records = $query->latest()->paginate(12)->appends($request->only('search'));

        return view('records.index', compact('records'));
    }

    public function show($id)
    {
        $record = Prestasi::with('user')
            ->where('status_prestasi', 'aktif')
            ->findOrFail($id);

        return view('records.show', compact('record'));
    }
}
