<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'pelanggan');

        // Search logic
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm) // Corrected this line
                  ->orWhere('nama_lengkap', 'like', $searchTerm);
            });
        }

        // Sorting logic
        $sortableColumns = ['nama_lengkap', 'email', 'jabatan_terkini', 'kategori'];
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $customers = $query->paginate(15)->appends($request->query());
        
        return view('admin.customers.index', compact('customers', 'sortBy', 'sortDirection'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $customer->load(['legacies' => function ($query) {
            $query->with('transactions');
        }, 'recommendations' => function ($query) {
            $query->with('transactions');
        }]);

        foreach ($customer->legacies as $legacy) {
            $pendingTransactions = $legacy->transactions->where('status', 'pending');
            $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            $legacy->has_pending_upgrade_payment = $pendingTransactions->where('transaction_type', 'upgrade')->isNotEmpty();
        }

        foreach ($customer->recommendations as $recommendation) {
            $pendingTransactions = $recommendation->transactions->where('status', 'pending');
            $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            $recommendation->has_pending_upgrade_payment = $pendingTransactions->where('transaction_type', 'upgrade')->isNotEmpty();
            $recommendation->has_pending_renewal_payment = $pendingTransactions->where('transaction_type', 'renewal')->isNotEmpty();
        }

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'jabatan_terkini' => 'nullable|string|max:255',
            'kategori' => 'required|string|in:Individu,Lembaga',
            'biodata' => 'nullable|string',
            'nomor_whatsapp' => 'nullable|string|max:20',
            'foto_pelanggan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto_pelanggan')) {
            // Delete old photo if it exists
            if ($customer->foto_pelanggan) {
                Storage::disk('public')->delete($customer->foto_pelanggan);
            }
            // Store new photo
            $path = $request->file('foto_pelanggan')->store('foto_pelanggan', 'public');
            $validated['foto_pelanggan'] = $path;
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }
}    