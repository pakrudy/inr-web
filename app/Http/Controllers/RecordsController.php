<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function index()
    {
        $records = Prestasi::with('user')
            ->where('status_prestasi', 'aktif') // Re-adding the status filter
            ->latest()
            ->paginate(12);

        return view('records.index', compact('records'));
    }
}
