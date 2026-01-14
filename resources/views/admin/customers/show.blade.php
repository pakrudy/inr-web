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
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->nama_lengkap ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pengguna</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->name }}</p>
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
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jabatan Terkini</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->jabatan_terkini ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-3">
                            <p class="text-sm font-medium text-gray-500">Biodata</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->biodata ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievements Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Prestasi yang Diajukan</h3>
                 <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Prestasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validitas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customer->prestasi as $achievement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $achievement->judul_prestasi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $achievement->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $achievement->status_prestasi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($achievement->validitas == 'valid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $achievement->validitas }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $achievement->validitas }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.achievements.show', $achievement) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Pelanggan ini belum mengajukan prestasi.</td>
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
