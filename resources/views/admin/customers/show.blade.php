<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pelanggan: ') }} {{ $customer->nama_lengkap ?? $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Customer Details Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Customer Photo -->
                    <div class="md:col-span-1 flex flex-col items-center">
                        @if ($customer->foto_pelanggan)
                            <img src="{{ asset('storage/' . $customer->foto_pelanggan) }}" alt="Foto Pelanggan" class="h-48 w-48 rounded-full object-cover shadow-md">
                        @else
                            <div class="h-48 w-48 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.993A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                        <p class="mt-4 text-sm font-semibold text-gray-700">{{ $customer->name }}</p>
                        @if ($customer->kategori === 'Individu')
                        <p class="text-xs bg-gray-500 text-white py-1 px-2">{{ $customer->kategori }}</p>
                        @else
                        <p class="text-xs bg-orange-500 text-white py-1 px-2">{{ $customer->kategori }}</p>
                        @endif
                    </div>

                    <!-- Customer Info -->
                    <div class="md:col-span-3">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->nama_lengkap ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->jenis_kelamin ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nomor Whatsapp</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->nomor_whatsapp ?? '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Jabatan Terkini</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->jabatan_terkini ?? '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Biodata</p>
                                    <p class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">{{ $customer->biodata ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legacies Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Legacy yang Diajukan</h3>
                 <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terindeks</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customer->legacies as $legacy)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $legacy->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $legacy->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ 
                                        ($legacy->status === 'pending' && $legacy->has_pending_initial_payment) 
                                            ? __('Waiting Approval') 
                                            : ucfirst($legacy->status) 
                                    }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($legacy->is_indexed)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ya</span>
                                        @elseif ($legacy->has_pending_upgrade_payment)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Waiting Approval</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.legacies.show', $legacy) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Pelanggan ini belum mengajukan legacy.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recommendations Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Rekomendasi yang Diajukan</h3>
                 <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tempat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terindeks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluarsa</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customer->recommendations as $recommendation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $recommendation->place_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $recommendation->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ 
                                        (($recommendation->status === 'pending' && $recommendation->has_pending_initial_payment) || ($recommendation->status === 'expired' && $recommendation->has_pending_renewal_payment)) 
                                            ? __('Waiting Approval') 
                                            : ucfirst($recommendation->status) 
                                    }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($recommendation->is_indexed)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ya</span>
                                        @elseif ($recommendation->has_pending_upgrade_payment)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Waiting Approval</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $recommendation->expires_at ? $recommendation->expires_at->format('d M Y') : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.recommendations.show', $recommendation) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Pelanggan ini belum mengajukan rekomendasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali ke Daftar Pelanggan</a>
            </div>

        </div>
    </div>
</x-app-layout>
