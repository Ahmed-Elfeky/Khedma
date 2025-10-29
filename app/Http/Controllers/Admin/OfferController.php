<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOfferRequest;
use App\Models\Offer;
use App\Models\Category;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with('category')->latest()->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.offers.create', compact('categories'));
    }

    public function store(StoreOfferRequest $request)
    {

        $data = $request->validated();
        
        Offer::create($data);

        return redirect()->route('admin.offers.index')->with('success', 'تم إنشاء العرض بنجاح ✅');
    }
    public function edit(Offer $offer)
    {
        $categories = Category::all();
        return view('admin.offers.edit', compact('offer', 'categories'));
    }

    public function update(StoreOfferRequest $request, Offer $offer)
    {
        $data = $request->validated();
        $offer->update($data);

        return redirect()->route('admin.offers.index')->with('success', 'تم تحديث العرض بنجاح ✅');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return back()->with('success', 'تم حذف العرض بنجاح ❌');
    }
}
