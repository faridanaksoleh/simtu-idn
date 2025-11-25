<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganKoordinatorExport;
use Illuminate\Support\Facades\Auth;

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
    public $studentStats = [];
    
    public $userClass;

    public function mount()
    {
        $this->userClass = Auth::user()->class;
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport()
    {
        $query = Transaction::with(['user', 'category'])
            ->whereHas('user', function($q) {
                $q->where('class', $this->userClass)
                  ->where('role', 'mahasiswa');
            })
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->reportType !== 'all') {
            $query->where('type', $this->reportType);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->transactions = $query->latest()->get();

        $this->totalIncome = $this->transactions
            ->where('type', 'income')
            ->where('status', 'approved')
            ->sum('amount');

        $this->totalExpense = $this->transactions
            ->where('type', 'expense')
            ->where('status', 'approved')
            ->sum('amount');

        $this->netBalance = $this->totalIncome - $this->totalExpense;

        $this->studentStats = User::where('role', 'mahasiswa')
            ->where('class', $this->userClass)
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
                $user->total_transactions = $user->total_transactions ?? 0;
                $user->total_savings = $user->total_savings ?? 0;
                return $user;
            })
            ->filter(function($user) {
                return $user->total_transactions > 0 || $user->total_savings > 0;
            });
    }

    public function exportPDF()
    {
        try {
            $this->generateReport();
            
            $data = [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalIncome' => $this->totalIncome,
                'totalExpense' => $this->totalExpense,
                'netBalance' => $this->netBalance,
                'transactions' => $this->transactions,
                'studentStats' => $this->studentStats,
                'reportType' => $this->reportType,
                'statusFilter' => $this->statusFilter,
                'className' => $this->userClass,
            ];

            $pdf = Pdf::loadHTML($this->generatePDFContent($data));
            
            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                'laporan-keuangan-' . $this->userClass . '-' . now()->format('Y-m-d') . '.pdf'
            );
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ]);
            return null;
        }
    }

    public function exportExcel()
    {
        try {
            $this->generateReport();
            
            $data = [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalIncome' => $this->totalIncome,
                'totalExpense' => $this->totalExpense,
                'netBalance' => $this->netBalance,
                'transactions' => $this->transactions,
                'studentStats' => $this->studentStats,
                'className' => $this->userClass,
            ];

            return Excel::download(
                new LaporanKeuanganKoordinatorExport($data), 
                'laporan-keuangan-' . $this->userClass . '-' . now()->format('Y-m-d') . '.xlsx'
            );
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Error generating Excel: ' . $e->getMessage()
            ]);
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
                <h1>Laporan Keuangan Kelas ' . $data['className'] . '</h1>
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
                        <th>Mahasiswa</th>
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
                        <th>Total Transaksi</th>
                        <th>Total Tabungan</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data['studentStats'] as $student) {
            $html .= '
                    <tr>
                        <td>' . $student->name . '</td>
                        <td>' . $student->email . '</td>
                        <td class="text-right">' . $student->total_transactions . '</td>
                        <td class="positive text-right">Rp ' . number_format($student->total_savings, 0, ',', '.') . '</td>
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
        return view('livewire.koordinator.laporan-keuangan')
            ->layout('layouts.app');
    }
}