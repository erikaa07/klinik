<?php

namespace App\Livewire\Dokter;

use Livewire\Component;
use App\Models\Obat;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapObat extends Component
{
    public $search = '';
    public $searchQuery = '';
    public $obats = [];

    public function mount()
    {
        if (auth()->user()->role !== 'dokter' && auth()->user()->role !== 'admin') {
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

    // CSV hanya 5 kolom
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
                    'No Batch' => $obat->no_batch,
                    'Exp Date' => $obat->exp_date,
                    'Stok Awal' => $obat->stok_awal,
                    'Sisa' => ($obat->stok_awal + ($obat->jumlah_masuk ?? 0)) - ($obat->jumlah_keluar ?? 0),
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
            if ($csvData->isNotEmpty()) {
                fputcsv($handle, array_keys($csvData->first()));
            }
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }

    // PDF 5 kolom, sane UTF-8, landscape, custom font, sama admin
    public function downloadPDF()
    {
        $pdfData = Obat::query()
            ->when($this->searchQuery, function ($q) {
                $q->where('nama', 'like', '%'.$this->searchQuery.'%');
            })
            ->get()
            ->map(function ($obat) {
                return [
                    'nama'      => mb_convert_encoding($obat->nama ?? '', 'UTF-8', 'UTF-8'),
                    'no_batch'  => mb_convert_encoding($obat->no_batch ?? '', 'UTF-8', 'UTF-8'),
                    'exp_date'  => mb_convert_encoding($obat->exp_date ?? '', 'UTF-8', 'UTF-8'),
                    'stok_awal' => mb_convert_encoding($obat->stok_awal ?? 0, 'UTF-8', 'UTF-8'),
                    'sisa_stok' => mb_convert_encoding(($obat->stok_awal + ($obat->jumlah_masuk ?? 0)) - ($obat->jumlah_keluar ?? 0), 'UTF-8', 'UTF-8'),
                ];
            });

        $pdf = Pdf::loadView('pdf.dokter-rekap-obat', ['obats' => $pdfData])
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'rekap_obat_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        return view('livewire.dokter.rekap-obat', [
            'obats' => $this->obats
        ])->layout('livewire.dokter.layout.dokter');
    }
}