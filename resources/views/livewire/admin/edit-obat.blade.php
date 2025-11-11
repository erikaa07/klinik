<div>
    @if($showEditModal)
    <div style="z-index:9999;background:rgba(0,0,0,0.5);position:fixed;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;">
        <div style="background:white;padding:30px;max-width:400px;width:100%;border-radius:10px;">
            <h3 class="text-lg font-bold mb-4">Edit Obat</h3>
            <form wire:submit.prevent="updateObat">
                <div class="mb-3">
                    <label class="block text-sm mb-1">Nama Obat</label>
                    <input type="text" wire:model.defer="editObatData.nama" class="border px-3 py-2 w-full rounded" placeholder="Nama Obat" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Harga Beli</label>
                    <input type="number" wire:model.defer="editObatData.harga_beli" class="border px-3 py-2 w-full rounded" placeholder="Harga Beli" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Harga Jual</label>
                    <input type="number" wire:model.defer="editObatData.harga_jual" class="border px-3 py-2 w-full rounded" placeholder="Harga Jual" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">No Batch</label>
                    <input type="text" wire:model.defer="editObatData.no_batch" class="border px-3 py-2 w-full rounded" placeholder="No Batch" />
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
</div>