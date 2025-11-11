<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Obat;

class EditObat extends Component
{
    public $obatId;
    public $editObatData = [
        'nama' => '',
        'harga_beli' => '',
        'harga_jual' => '',
        'no_batch' => '',
        'exp_date' => '',
    ];
    public $showEditModal = false;

    // Listener tanpa parameter!
    protected $listeners = ['openEditModal'];

    // Method listener menerima event (Livewire akan inject params otomatis)
    public function openEditModal($id)
    {
        $obat = Obat::findOrFail($id);
        $this->obatId = $id;
        $this->editObatData = [
            'nama' => $obat->nama,
            'harga_beli' => $obat->harga_beli,
            'harga_jual' => $obat->harga_jual,
            'no_batch' => $obat->no_batch,
            'exp_date' => $obat->exp_date,
        ];
        $this->showEditModal = true;
    }

    public function updateObat()
    {
        $this->validate([
            'editObatData.nama' => 'required|string',
            'editObatData.harga_beli' => 'required|numeric',
            'editObatData.harga_jual' => 'required|numeric',
            'editObatData.no_batch' => 'required|string',
            'editObatData.exp_date' => 'required|date',
        ]);
        Obat::findOrFail($this->obatId)->update($this->editObatData);
        $this->showEditModal = false;
        $this->dispatch('obatUpdated');
        session()->flash('message', 'Obat berhasil diupdate!');
    }

    public function render()
    {
        return view('livewire.admin.edit-obat');
    }
}