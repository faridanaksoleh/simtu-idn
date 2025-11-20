<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanKeuanganKoordinatorExport implements FromArray, WithTitle, WithStyles, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $exportData = [];

        // Header laporan
        $exportData[] = ['LAPORAN KEUANGAN KELAS ' . $this->data['className']];
        $exportData[] = ['Periode:', Carbon::parse($this->data['startDate'])->format('d M Y') . ' - ' . Carbon::parse($this->data['endDate'])->format('d M Y')];
        $exportData[] = [''];
        
        // Ringkasan
        $exportData[] = ['RINGKASAN'];
        $exportData[] = ['Total Pemasukan', 'Rp ' . number_format($this->data['totalIncome'], 0, ',', '.')];
        $exportData[] = ['Total Pengeluaran', 'Rp ' . number_format($this->data['totalExpense'], 0, ',', '.')];
        $exportData[] = ['Saldo Bersih', 'Rp ' . number_format($this->data['netBalance'], 0, ',', '.')];
        $exportData[] = [''];
        
        // Transaksi header
        $exportData[] = ['TRANSAKSI'];
        $exportData[] = ['Tanggal', 'Mahasiswa', 'Tipe', 'Kategori', 'Jumlah', 'Status', 'Deskripsi'];
        
        // Transaksi data
        foreach ($this->data['transactions'] as $transaction) {
            $exportData[] = [
                $transaction->created_at->format('d/m/Y'),
                $transaction->user->name,
                ucfirst($transaction->type),
                $transaction->category->name,
                'Rp ' . number_format($transaction->amount, 0, ',', '.'),
                ucfirst($transaction->status),
                $transaction->description ?? '-'
            ];
        }
        
        $exportData[] = [''];
        
        // Statistik Mahasiswa header
        $exportData[] = ['STATISTIK MAHASISWA'];
        $exportData[] = ['Nama', 'Email', 'Total Transaksi', 'Total Tabungan'];
        
        // Statistik data
        foreach ($this->data['studentStats'] as $student) {
            $exportData[] = [
                $student->name,
                $student->email,
                $student->total_transactions,
                'Rp ' . number_format($student->total_savings, 0, ',', '.')
            ];
        }
        
        $exportData[] = [''];
        $exportData[] = ['Generated on', now()->format('d M Y H:i')];

        return $exportData;
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            4 => ['font' => ['bold' => true, 'size' => 14]],
            9 => ['font' => ['bold' => true, 'size' => 14]],
            10 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge cells untuk header
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A4:G4');
                $event->sheet->mergeCells('A9:G9');
                
                // Set alignment untuk header
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A9')->getAlignment()->setHorizontal('center');
                
                // Auto size columns
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                foreach ($columns as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}