<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     * Dilengkapi filter berdasarkan status.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user') // N+1 prevention
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (misal: processing -> shipped)
     * Handle otomatis pengembalian stok jika status diubah jadi Cancelled.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Logika Restock jika status diubah ke Cancelled
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', "Status pesanan #{$order->order_number} diperbarui menjadi " . ucfirst($newStatus));
    }

    /**
     * Menghapus pesanan.
     * Menggunakan Database Transaction untuk keamanan data.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();

        try {
            // Jika pesanan dihapus tapi statusnya bukan 'cancelled', 
            // kita kembalikan stoknya terlebih dahulu agar stok tidak hilang.
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            // Hapus data order (item terkait biasanya terhapus otomatis jika ada cascade delete di DB)
            $order->delete();

            DB::commit();
            return redirect()->route('admin.orders.index')
                ->with('success', "Pesanan #{$order->order_number} berhasil dihapus dan stok telah diperbarui.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.orders.index')
                ->with('error', "Gagal menghapus pesanan: " . $e->getMessage());
        }
    }
}