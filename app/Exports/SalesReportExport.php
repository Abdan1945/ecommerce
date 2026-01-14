<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill; // Import eksplisit untuk Fill style

class SalesReportExport implements 
    FromQuery, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    WithColumnFormatting, 
    ShouldAutoSize
{
    use Exportable;

    public function __construct(
        protected string $dateFrom,
        protected string $dateTo
    ) {}

    /**
     * Query data untuk dieksport
     */
    public function query()
    {
        return Order::query()
            ->with(['user', 'items'])
            ->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->where('payment_status', 'paid') 
            ->orderBy('created_at', 'asc');
    }

    /**
     * Header tabel
     */
    public function headings(): array
    {
        return [
            'No. Order',
            'Tanggal Transaksi',
            'Nama Customer',
            'Email',
            'Jumlah Item',
            'Total Belanja',
            'Status'
        ];
    }

    /**
     * Mapping data per baris
     */
    public function map($order): array
    {
        return [
            // Menggunakan tanda kutip satu di depan agar No Order tidak jadi scientific format
            " " . $order->order_number, 
            $order->created_at->format('d/m/Y H:i'),
            $order->user->name ?? 'Guest',
            $order->user->email ?? '-',
            (int) ($order->items_sum_quantity ?? $order->items->sum('quantity')),
            (float) $order->total_amount,
            ucfirst($order->status),
        ];
    }

    /**
     * Format Kolom F (Total Belanja) agar ada pemisah ribuan
     */
    public function columnFormats(): array
    {
        return [
            'F' => '#,##0', 
        ];
    }

    /**
     * Styling baris pertama (Header)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EFEFEF']
                ]
            ],
        ];
    }
}