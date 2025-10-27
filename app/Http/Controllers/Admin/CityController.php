<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCityRequest;
use App\Http\Requests\Admin\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::latest()->paginate(6);
        return view('admin.cities.index',compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(StoreCityRequest $request)
    {
         City::create($request->validated());
        return redirect()->route('admin.cities.index')->with('success', 'تمت إضافة المدينة بنجاح');
    }


    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->validated());
        return redirect()->route('admin.cities.index')->with('success', 'تم تحديث المدينة بنجاح');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'تم حذف المدينة بنجاح');
    }
}
