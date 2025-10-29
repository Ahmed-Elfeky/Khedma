<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'city'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'city', 'products'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    public function print($id)
    {
        $order = Order::with(['user', 'city', 'products'])->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivered',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;
        // لو لم تتغير الحالة، لا تسجل
        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم تغيير الحالة (نفس الحالة السابقة).',
            ]);
        }
        $order->update(['status' => $newStatus]);
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطلب بنجاح وتسجيلها في السجل.',
        ]);
    }
}
