<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\SalesReportExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // 1. Tentukan Rentang Tanggal
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        // --- LOGIKA EXPORT DIMULAI ---
        // Jika ada parameter 'export' di URL, langsung download
        if ($request->has('export')) {
            return Excel::download(
                new SalesReportExport($dateFrom, $dateTo), 
                "laporan-penjualan-{$dateFrom}-sd-{$dateTo}.xlsx"
            );
        }
        // --- LOGIKA EXPORT SELESAI ---

        // 2. Query Utama (Tabel Transaksi Detail)
        $orders = Order::with(['items', 'user'])
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('payment_status', 'paid')
            ->latest()
            ->paginate(20)
            ->withQueryString(); // Agar pagination menjaga filter tanggal saat pindah halaman

        // 3. Query Summary
        $summary = Order::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('payment_status', 'paid')
            ->selectRaw('COUNT(*) as total_orders, SUM(total_amount) as total_revenue')
            ->first();

        // 4. Query Analitik: Penjualan per Kategori
        $byCategory = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('orders.created_at', '>=', $dateFrom)
            ->whereDate('orders.created_at', '<=', $dateTo)
            ->where('orders.payment_status', 'paid')
            ->groupBy('categories.id', 'categories.name')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.subtotal) as total')
            )
            ->orderByDesc('total')
            ->get();

        return view('admin.reports.sales', compact('orders', 'summary', 'byCategory', 'dateFrom', 'dateTo'));
    }
}