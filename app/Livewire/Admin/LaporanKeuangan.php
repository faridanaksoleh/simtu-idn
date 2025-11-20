<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganAdminExport;

class LaporanKeuangan extends Component
{
    public $startDate;
    public $endDate;
    public $reportType = 'all';
    public $statusFilter = 'approved';

    public $totalIncome = 0;
    public $totalExpense = 0;
    public $netBalance = 0;
    public $transactions = [];
    public $userStats = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport()
    {
        $query = Transaction::with(['user', 'category'])
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->reportType !== 'all') {
            $query->where('type', $this->reportType);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->transactions = $query->latest()->get();

        // Calculate totals - hanya hitung yang approved
        $this->totalIncome = $this->transactions
            ->where('type', 'income')
            ->where('status', 'approved')
            ->sum('amount');

        $this->totalExpense = $this->transactions
            ->where('type', 'expense')
            ->where('status', 'approved')
            ->sum('amount');

        $this->netBalance = $this->totalIncome - $this->totalExpense;

        // User statistics - HAPUS DUPLIKASI, GUNAKAN INI SAJA
        $this->userStats = User::where('role', 'mahasiswa')
            ->withCount(['transactions as total_transactions' => function($query) {
                $query->whereBetween('date', [$this->startDate, $this->endDate])
                    ->where('status', 'approved');
            }])
            ->withSum(['transactions as total_savings' => function($query) {
                $query->where('type', 'income')
                    ->whereBetween('date', [$this->startDate, $this->endDate])
                    ->where('status', 'approved');
            }], 'amount')
            ->get()
            ->map(function($user) {
                // Pastikan nilai default untuk menghindari null
                $user->total_transactions = $user->total_transactions ?? 0;
                $user->total_savings = $user->total_savings ?? 0;
                return $user;
            })
            ->filter(function($user) {
                // Filter manual: tampilkan user yang memiliki transaksi ATAU tabungan
                return $user->total_transactions > 0 || $user->total_savings > 0;
            });

        // Debug: log hasil query - TAMBAHKAN INI UNTUK DEBUG
        \Log::info('User Stats After Generate:', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'userStats_count' => $this->userStats->count(),
            'userStats' => $this->userStats->map(function($user) {
                return [
                    'name' => $user->name,
                    'total_transactions' => $user->total_transactions,
                    'total_savings' => $user->total_savings,
                ];
            })->toArray()
        ]);
    }

    public function exportPDF()
    {
        try {
            // PASTIKAN DATA TERBARU DENGAN MEMANGGIL generateReport() SEBELUM EXPORT
            $this->generateReport();
            
            $data = [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalIncome' => $this->totalIncome,
                'totalExpense' => $this->totalExpense,
                'netBalance' => $this->netBalance,
                'transactions' => $this->transactions,
                'userStats' => $this->userStats,
                'reportType' => $this->reportType,
                'statusFilter' => $this->statusFilter,
            ];

            // Debug sebelum generate PDF
            \Log::info('PDF Export Data:', [
                'userStats_count' => $data['userStats']->count(),
                'userStats' => $data['userStats']->map(function($user) {
                    return [
                        'name' => $user->name,
                        'total_savings' => $user->total_savings,
                    ];
                })->toArray()
            ]);

            $pdf = Pdf::loadHTML($this->generatePDFContent($data));
            
            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                'laporan-keuangan-' . now()->format('Y-m-d') . '.pdf'
            );
            
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error generating PDF: ' . $e->getMessage());
            return null;
        }
    }

    public function exportExcel()
    {
        try {
            // PASTIKAN DATA TERBARU DENGAN MEMANGGIL generateReport() SEBELUM EXPORT
            $this->generateReport();
            
            $data = [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalIncome' => $this->totalIncome,
                'totalExpense' => $this->totalExpense,
                'netBalance' => $this->netBalance,
                'transactions' => $this->transactions,
                'userStats' => $this->userStats,
            ];

            // Debug sebelum generate Excel
            \Log::info('Excel Export Data:', [
                'userStats_count' => $data['userStats']->count(),
                'userStats' => $data['userStats']->map(function($user) {
                    return [
                        'name' => $user->name,
                        'total_savings' => $user->total_savings,
                    ];
                })->toArray()
            ]);

            return Excel::download(new LaporanKeuanganAdminExport($data), 'laporan-keuangan-' . now()->format('Y-m-d') . '.xlsx');
            
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error generating Excel: ' . $e->getMessage());
            return null;
        }
    }

    private function generatePDFContent($data)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title>Laporan Keuangan</title>
            <style>
                body { font-family: DejaVu Sans, sans-serif; margin: 20px; font-size: 12px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                .summary { margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 5px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
                th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .positive { color: green; }
                .negative { color: red; }
                .section-title { background: #333; color: white; padding: 8px; margin-top: 15px; margin-bottom: 8px; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Laporan Keuangan SIMTU IDN</h1>
                <h3>Periode: ' . Carbon::parse($data['startDate'])->format('d M Y') . ' - ' . Carbon::parse($data['endDate'])->format('d M Y') . '</h3>
                <p>Generated on: ' . now()->format('d M Y H:i') . '</p>
            </div>
            
            <div class="summary">
                <h3>Ringkasan</h3>
                <table>
                    <tr>
                        <td width="30%"><strong>Total Pemasukan</strong></td>
                        <td class="positive text-right"><strong>Rp ' . number_format($data['totalIncome'], 0, ',', '.') . '</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total Pengeluaran</strong></td>
                        <td class="negative text-right"><strong>Rp ' . number_format($data['totalExpense'], 0, ',', '.') . '</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Saldo Bersih</strong></td>
                        <td class="' . ($data['netBalance'] >= 0 ? 'positive' : 'negative') . ' text-right">
                            <strong>Rp ' . number_format($data['netBalance'], 0, ',', '.') . '</strong>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="section-title">TRANSAKSI (' . count($data['transactions']) . ' records)</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data['transactions'] as $transaction) {
            $html .= '
                    <tr>
                        <td>' . $transaction->created_at->format('d/m/Y') . '</td>
                        <td>' . $transaction->user->name . '</td>
                        <td>' . ucfirst($transaction->type) . '</td>
                        <td>' . $transaction->category->name . '</td>
                        <td class="' . ($transaction->amount >= 0 ? 'positive' : 'negative') . ' text-right">
                            ' . ($transaction->amount >= 0 ? '+' : '-') . 'Rp' . number_format(abs($transaction->amount), 0, ',', '.') . '
                        </td>
                        <td>' . ucfirst($transaction->status) . '</td>
                        <td>' . ($transaction->description ?? '-') . '</td>
                    </tr>';
        }

        $html .= '
                </tbody>
            </table>
            
            <div class="section-title">STATISTIK MAHASISWA</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Total Transaksi</th>
                        <th>Total Tabungan</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data['userStats'] as $user) {
            $html .= '
                    <tr>
                        <td>' . $user->name . '</td>
                        <td>' . $user->email . '</td>
                        <td>' . $user->class . '</td>
                        <td class="text-right">' . $user->total_transactions . '</td>
                        <td class="positive text-right">Rp ' . number_format($user->total_savings, 0, ',', '.') . '</td>
                    </tr>';
        }

        $html .= '
                </tbody>
            </table>
        </body>
        </html>';

        return $html;
    }

    public function render()
    {
        return view('livewire.admin.laporan-keuangan')
            ->layout('layouts.app');
    }
}