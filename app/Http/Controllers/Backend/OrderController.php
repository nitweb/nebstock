<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SiteSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  LIST
    // ─────────────────────────────────────────────────────────────────────────
    public function OrderList()
    {
        $orders = Order::latest()
            ->with(['user', 'items'])
            ->get();

        return view('backend.orders.list', compact('orders'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DETAIL
    // ─────────────────────────────────────────────────────────────────────────
    public function OrderDetail(int $id)
    {
        $order    = Order::with(['user', 'items.product'])->findOrFail($id);
        $statuses = Order::statuses();

        return view('backend.orders.detail', compact('order', 'statuses'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DOWNLOAD INVOICE PDF
    // ─────────────────────────────────────────────────────────────────────────
    public function DownloadInvoice(int $id)
    {
        $order    = Order::with(['user', 'items.product'])->findOrFail($id);
        $settings = SiteSettings::first();

        $pdf = Pdf::loadView('backend.orders.invoice', compact('order', 'settings'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'isLocalLinksEnabled'  => true,
                'chroot'               => public_path(),
                'defaultFont'          => 'DejaVu Sans',
                'dpi'                  => 150,
            ]);

        $filename = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->download($filename);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE STATUS
    // ─────────────────────────────────────────────────────────────────────────
    public function UpdateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        try {
            Order::findOrFail($id)->update(['status' => $request->status]);

            return redirect()
                ->back()
                ->with(['message' => 'Order status updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Order Status Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to update status.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE PAYMENT STATUS
    // ─────────────────────────────────────────────────────────────────────────
    public function UpdatePaymentStatus(Request $request, int $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        try {
            Order::findOrFail($id)->update(['payment_status' => $request->payment_status]);

            return redirect()
                ->back()
                ->with(['message' => 'Payment status updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Payment Status Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to update payment status.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function OrderDelete(int $id)
    {
        try {
            Order::findOrFail($id)->delete();

            return redirect()
                ->route('backend.orders.list')
                ->with(['message' => 'Order deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Order Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to delete order.', 'alert-type' => 'error']);
        }
    }
}
