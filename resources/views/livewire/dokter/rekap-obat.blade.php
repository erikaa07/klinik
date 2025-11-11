<div class="overflow-x-auto bg-grey p-6 rounded-lg shadow-lg max-w-4xl w-full mx-auto">
    <h2 class="text-xl font-bold mb-6 text-gray-800 text-center sm:text-left">Rekap Obat</h2>
    
    {{-- Search bar & Export buttons --}}
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
        <button wire:click="downloadCSV"
            class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition font-semibold"
            type="button">
            Export CSV
        </button>
        <button wire:click="downloadPDF"
            class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition font-semibold"
            type="button">
            Export PDF
        </button>
    </div>

    <table class="min-w-full border border-gray-200 bg-grey rounded-lg overflow-hidden text-sm filament-tables-table">
        <thead>
            <tr class="bg-primary-100">
                <th class="px-4 py-3 border-b text-left font-semibold text-primary-700">Nama</th>
                <th class="px-4 py-3 border-b text-left font-semibold text-primary-700">No Batch</th>
                <th class="px-4 py-3 border-b text-center font-semibold text-primary-700">Exp Date</th>
                <th class="px-4 py-3 border-b text-right font-semibold text-primary-700">Stok Awal</th>
                <th class="px-4 py-3 border-b text-right font-semibold text-primary-700">Sisa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($obats as $obat)
            <tr class="hover:bg-primary-50 transition-colors">
                <td class="px-4 py-3 border-b">{{ $obat->nama }}</td>
                <td class="px-4 py-3 border-b">{{ $obat->no_batch }}</td>
                <td class="px-4 py-3 border-b text-center">{{ $obat->exp_date }}</td>
                <td class="px-4 py-3 border-b text-right">{{ $obat->stok_awal }}</td>
                <td class="px-4 py-3 border-b text-right font-bold text-success-700">{{ $obat->sisa_stok ?? 0 }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data obat</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>