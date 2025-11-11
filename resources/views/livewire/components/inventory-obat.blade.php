<div x-data="{ showToast: false }">
    <button
        type="button"
        wire:click="goToInventory"
        class="flex flex-col gap-2 bg-blue-50 hover:bg-blue-100 p-6 rounded-lg shadow ring-1 ring-blue-100 transition border border-blue-200 w-full"
    >
        <div class="flex items-center gap-2">
            <span class="inline-block bg-blue-600/10 text-blue-600 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 10h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="text-lg font-semibold text-blue-700">Inventory Obat (Khusus Admin)</span>
        </div>
        <p class="text-gray-600 text-sm">Kelola data stok obat, update jumlah, tambah stok baru, dan monitoring inventory.</p>
    </button>

    {{-- Toast popup --}}
    <div
        x-show="showToast"
        x-transition
        @toast.window="showToast = true; setTimeout(() => showToast = false, 2500)"
        class="fixed top-6 right-6 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50"
        style="display:none;"
    >
        Anda bukan admin!
    </div>
</div>