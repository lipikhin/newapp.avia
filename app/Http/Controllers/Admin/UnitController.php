<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder;
use App\Models\Manual;
use App\Models\Plane;
use App\Models\Scope;
use App\Models\Unit;
use Illuminate\Http\Request;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все units и связанные с ними manuals
        $units = Unit::with('manuals')->get()->groupBy(function ($unit) {
            return $unit->manuals ? $unit->manuals->number : 'No CMM';
        });

        // Получаем все записи из Manual
        $manuals = Manual::all();

        // Подготовка данных для отображения в виде
        $planes = Plane::pluck('type', 'id');
        $builders = Builder::pluck('name', 'id');
        $scopes = Scope::pluck('scope', 'id');

        // Передаем данные в представление
        return view('admin.units.index', compact('units', 'manuals', 'planes', 'builders', 'scopes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manuals = Manual::all();
        $planes = Plane::all(); // Получить все объекты AirCraft
        $builders = Builder::all(); // Получить все объекты MFR
        $scopes = Scope::all(); // Получить все объекты Scope

        return view('admin.units.create', compact('manuals','planes', 'builders',
            'scopes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cmm_id' => 'required|exists:manuals,id',
            'part_numbers' => 'required|array',
            'part_numbers.*' => 'string|distinct',
        ]);

        foreach ($request->part_numbers as $partNumber) {
            Unit::create([
                'manuals_id' => $request->cmm_id,
                'part_number' => $partNumber,
            ]);
        }

        return response()->json(['success' => true]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($manuals_id)
    {
        $manuals = Manual::with('units')->find($manuals_id); // Получаем
        // мануал с юнитами
        return view('admin.units.index', compact('manuals'));
    }


//    public function edit(string $id)
//    {
//        $unit = Unit::findOrFail($id);
//        $manuals = Manual::pluck('number', 'id');
//
////        dd($cmms); // Временная проверка
//
//
//        return view('admin.units.edit', compact('unit', 'manuals'));
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'part_numbers' => 'required|array',
            'part_numbers.*' => 'string|max:255',
        ]);

        // Получаем все Part Numbers и обновляем их для данного unit
        $unit->part_number = json_encode($validated['part_numbers']); // If part_number is stored as a JSON field, adapt this
        $unit->save();

        return response()->json([
            'success' => true,
            'message' => 'Unit updated successfully'
        ]);
    }


//    public function update(Request $request, string $id)
//    {
//        $validatedData = $request->validate([
//            'part_number' => 'required|string|max:255',
//            'active' => 'boolean',
//            'manuals_id' => 'required|exists:manuals,id',
//        ]);
//
//        Unit::whereId($id)->update($validatedData);
//        return redirect()->route('admin.units.index')->with('success', 'Unit has been updated');
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Unit has been deleted');

    }
}
