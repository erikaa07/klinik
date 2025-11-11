<div>
    <!-- Modal Edit Obat (dalam satu komponen) -->
    @if($showEditModal)
    <div style="z-index:9999;background:rgba(0,0,0,0.5);position:fixed;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;">
        <div style="background:white;padding:3h0px;max-width:400px;width:100%;border-radius:10px;">
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

    <!-- Tabel Rekap -->
    <div class="overflow-x-auto bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full mx-auto">
        <h2 class="text-xl font-bold mb-6 text-gray-800 text-center sm:text-left">Rekap Obat</h2>
        @if(session()->has('message'))
            <div class="mb-3 p-3 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-4 flex items-center gap-2">
            <form wire:submit.prevent="submitSearch" class="flex items-center gap-2">
                <input
                    type="text"
                    wire:model.defer="search"
                    placeholder="Cari nama obat ..."
                    class="border px-4 py-2 rounded w-full max-w-xs"
                />
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">
                    Search
                </button>
            </form>
            <button wire:click="downloadPDF"
                class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition font-semibold">
                Export PDF
            </button>
            <button wire:click="downloadCSV"
                class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition font-semibold">
                Export CSV
            </button>
        </div>

        <table class="min-w-full border border-gray-200 bg-white rounded-lg overflow-hidden text-sm">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>No Batch</th>
                    <th>Exp Date</th>
                    <th>Stok Awal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Sisa</th>
                    <th>Laba</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obats as $obat)
                <tr>
                    <td>{{ $obat->nama }}</td>
                    <td>{{ number_format($obat->harga_beli) }}</td>
                    <td>{{ number_format($obat->harga_jual) }}</td>
                    <td>{{ $obat->no_batch }}</td>
                    <td>{{ $obat->exp_date }}</td>
                    <td>{{ $obat->stok_awal }}</td>
                    <td>{{ $obat->jumlah_masuk ?? 0 }}</td>
                    <td>{{ $obat->jumlah_keluar ?? 0 }}</td>
                    <td>{{ $obat->sisa_stok ?? 0 }}</td>
                    <td>{{ $obat->laba ?? 0 }}</td>
                    <td class="flex gap-1">
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
                @endforeach
                @if($obats->isEmpty())
                <tr>
                    <td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data obat</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>