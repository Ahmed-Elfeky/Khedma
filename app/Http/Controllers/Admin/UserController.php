<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $orders = $user->orders()->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }


    public function approve(User $user)
{
    $user->update(['is_approved' => true]);
    return response()->json(['message' => 'تم اعتماد الشركة بنجاح']);
}
}
