<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Obat;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapObat extends Component
{
    public $search = '';
    public $searchQuery = '';
    public $obats = [];
    public $showEditModal = false;
    public $editObatData = [
        'nama' => '',
        'harga_beli' => '',
        'harga_jual' => '',
        'no_batch' => '',
        'exp_date' => '',
    ];
    public $selectedObatId;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $this->getObats();
    }

    public function submitSearch()
    {
        $this->searchQuery = $this->search;
        $this->getObats();
    }

    public function getObats()
    {
        $this->obats = Obat::query()
            ->when($this->searchQuery, function ($q) {
                $q->where('nama', 'like', '%'.$this->searchQuery.'%');
            })
            ->get();
    }

    public function editObat($id)
    {
        $obat = Obat::findOrFail($id);
        $this->editObatData = [
            'nama' => $obat->nama,
            'harga_beli' => $obat->harga_beli,
            'harga_jual' => $obat->harga_jual,
            'no_batch' => $obat->no_batch,
            'exp_date' => $obat->exp_date,
        ];
        $this->selectedObatId = $id;
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
        Obat::findOrFail($this->selectedObatId)->update($this->editObatData);
        $this->showEditModal = false;
        $this->getObats();
        session()->flash('message', 'Obat berhasil diupdate!');
    }

    public function deleteObat($id)
    {
        Obat::findOrFail($id)->delete();
        $this->getObats();
        session()->flash('message', 'Obat berhasil dihapus!');
    }

    public function downloadPDF()
    {
        $pdfData = Obat::query()
            ->when($this->searchQuery, function ($q) {
                $q->where('nama', 'like', '%'.$this->searchQuery.'%');
            })
            ->get()
            ->map(function ($obat) {
                // Sanitasi data untuk UTF-8
                return [
                    'nama' => mb_convert_encoding($obat->nama ?? '', 'UTF-8', 'UTF-8'),
                    'harga_beli' => $obat->harga_beli,
                    'harga_jual' => $obat->harga_jual,
                    'no_batch' => mb_convert_encoding($obat->no_batch ?? '', 'UTF-8', 'UTF-8'),
                    'exp_date' => $obat->exp_date,
                    'stok_awal' => $obat->stok_awal,
                    'jumlah_masuk' => $obat->jumlah_masuk ?? 0,
                    'jumlah_keluar' => $obat->jumlah_keluar ?? 0,
                    'sisa_stok' => $obat->sisa_stok ?? 0,
                    'laba' => $obat->laba ?? 0,
                ];
            });

        $pdf = Pdf::loadView('pdf.rekap-obat', ['obats' => $pdfData])
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans');
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'rekap_obat_' . now()->format('Ymd_His') . '.pdf');
    }

    public function downloadCSV()
    {
        $csvData = Obat::query()
            ->when($this->searchQuery, function ($q) {
                $q->where('nama', 'like', '%'.$this->searchQuery.'%');
            })
            ->get()
            ->map(function ($obat) {
                return [
                    'Nama' => $obat->nama,
                    'Harga Beli' => $obat->harga_beli,
                    'Harga Jual' => $obat->harga_jual,
                    'No Batch' => $obat->no_batch,
                    'Exp Date' => $obat->exp_date,
                    'Stok Awal' => $obat->stok_awal,
                    'Masuk' => $obat->jumlah_masuk ?? 0,
                    'Keluar' => $obat->jumlah_keluar ?? 0,
                    'Sisa' => $obat->sisa_stok ?? 0,
                    'Laba' => $obat->laba ?? 0,
                ];
            });

        $csvFileName = 'rekap_obat_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response()->stream(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            
            // BOM UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            if ($csvData->isNotEmpty()) {
                fputcsv($handle, array_keys($csvData->first()));
            }
            
            // Data CSV
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            
            fclose($handle);
        }, 200, $headers);
    }

    public function render()
    {
        return view('livewire.admin.rekap-obat', [
            'obats' => $this->obats
        ])->layout('livewire.admin.layout.admin');
    }
}