<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date',   now()->format('Y-m-d'));

        $transactions = auth()->user()->transactions()
            ->withCount('items')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderByDesc('transaction_date')
            ->get();

        $totalRevenue      = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();

        return view('reports.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date',   now()->format('Y-m-d'));

        $transactions = auth()->user()->transactions()
            ->with('items')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderByDesc('transaction_date')
            ->get();

        $rows = ["Tanggal,Kode Transaksi,Produk,Jumlah,Harga (Rp),Subtotal (Rp),Total Transaksi (Rp)"];

        foreach ($transactions as $tx) {
            $first = true;
            foreach ($tx->items as $item) {
                $rows[] = implode(',', [
                    $tx->transaction_date->format('d/m/Y'),
                    $tx->transaction_code,
                    '"' . str_replace('"', '""', $item->product_name) . '"',
                    $item->quantity,
                    number_format($item->price, 0, ',', '.'),
                    number_format($item->subtotal, 0, ',', '.'),
                    $first ? number_format($tx->total_amount, 0, ',', '.') : '',
                ]);
                $first = false;
            }
        }

        $csv      = implode("\n", $rows);
        $fileName = 'laporan_' . $startDate . '_' . $endDate . '.csv';

        return Response::make($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
