<?php

namespace App\Livewire\Components;

use Livewire\Component;

class InventoryObat extends Component
{
    public function goToInventory()
    {
        if (auth()->user()->role !== 'admin') {
            // Livewire v3: gunakan dispatch() untuk event browser
            $this->dispatch('show-toast', message: 'Akses ditolak! Hanya admin yang bisa mengakses halaman ini.');
        } else {
            return redirect()->route('admin.rekap-obat');
        }
    }

    public function render()
    {
        return view('livewire.components.inventory-obat');
    }
}