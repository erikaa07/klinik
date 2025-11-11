<div class="min-h-[83vh] flex justify-center items-start">
    <div class="w-full max-w-5xl bg-white shadow-lg rounded-lg mt-12 mb-0 p-7">
        <h2 class="text-xl font-bold mb-6 text-gray-900 text-center sm:text-left">Rekap Obat</h2>
        
        @if(session()->has('message'))
            <div class="mb-3 p-3 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <!-- Modal Edit Obat (hanya 1x di root komponen) -->
        @if($showEditModal)
        <div class="fixed z-50 inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white p-7 rounded-lg shadow w-full max-w-sm relative">
                <h3 class="text-lg font-bold mb-4">Edit Obat</h3>
                <form wire:submit.prevent="updateObat">
                    <div class="mb-3">
                        <label class="block text-sm mb-1">Nama Obat</label>
                        <input type="text" wire:model.defer="editObatData.nama" class="border px-3 py-2 w-full rounded" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm mb-1">Harga Beli</label>
                        <input type="number" wire:model.defer="editObatData.harga_beli" class="border px-3 py-2 w-full rounded" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm mb-1">Harga Jual</label>
                        <input type="number" wire:model.defer="editObatData.harga_jual" class="border px-3 py-2 w-full rounded" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm mb-1">No Batch</label>
                        <input type="text" wire:model.defer="editObatData.no_batch" class="border px-3 py-2 w-full rounded" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm mb-1">Exp Date</label>
                        <input type="date" wire:model.defer="editObatData.exp_date" class="border px-3 py-2 w-full rounded" />
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="mb-4 flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <form wire:submit.prevent="submitSearch" class="flex items-center gap-2 w-full max-w-xs">
                <input
                    type="text"
                    wire:model.defer="search"
                    placeholder="Cari nama obat ..."
                    class="border px-4 py-2 rounded w-full"
                />
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">
                    Search
                </button>
            </form>
            <div class="flex gap-2">
                <button wire:click="downloadPDF"
                    class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition font-semibold">
                    Export PDF
                </button>
                <button wire:click="downloadCSV"
                    class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition font-semibold">
                    Export CSV
                </button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm mt-2">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">Harga Beli</th>
                        <th class="px-3 py-2">Harga Jual</th>
                        <th class="px-3 py-2">No Batch</th>
                        <th class="px-3 py-2">Exp Date</th>
                        <th class="px-3 py-2">Stok Awal</th>
                        <th class="px-3 py-2">Masuk</th>
                        <th class="px-3 py-2">Keluar</th>
                        <th class="px-3 py-2">Sisa</th>
                        <th class="px-3 py-2">Laba</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obats as $obat)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $obat->nama }}</td>
                        <td class="px-3 py-2">{{ number_format($obat->harga_beli) }}</td>
                        <td class="px-3 py-2">{{ number_format($obat->harga_jual) }}</td>
                        <td class="px-3 py-2">{{ $obat->no_batch }}</td>
                        <td class="px-3 py-2">{{ $obat->exp_date }}</td>
                        <td class="px-3 py-2">{{ $obat->stok_awal }}</td>
                        <td class="px-3 py-2">{{ $obat->jumlah_masuk ?? 0 }}</td>
                        <td class="px-3 py-2">{{ $obat->jumlah_keluar ?? 0 }}</td>
                        <td class="px-3 py-2">{{ $obat->sisa_stok ?? 0 }}</td>
                        <td class="px-3 py-2">{{ $obat->laba ?? 0 }}</td>
                        <td class="flex gap-1 p-2">
                            <button wire:click="editObat({{ $obat->id }})"
                                class="bg-yellow-400 text-white px-2 py-1 rounded shadow hover:bg-yellow-500 transition text-xs font-bold">
                                Edit
                            </button>
                            <button wire:click="deleteObat({{ $obat->id }})" 
                                onclick="return confirm('Yakin ingin menghapus obat ini?')"
                                class="bg-red-500 text-white px-2 py-1 rounded shadow hover:bg-red-600 transition text-xs font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data obat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>