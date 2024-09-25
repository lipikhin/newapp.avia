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
        $units = Unit::with('manuals')->get();

        // Проверка загруженных данных
        if ($units->isEmpty()) {
            // Выводим сообщение, если units пусты
            return view('admin.units.index', ['message' => 'No units found.']);
        }

        // Группируем по manuals->number, если у unit есть связанные manuals
        $groupedUnits = $units->groupBy(function ($unit) {
            return $unit->manuals ? $unit->manuals->number : 'No CMM';
        });

        // Получаем все записи из Manual
        $manuals = Manual::all();

        // Подготовка данных для отображения в виде
        $planes = Plane::pluck('type', 'id');
        $builders = Builder::pluck('name', 'id');
        $scopes = Scope::pluck('scope', 'id');

        // Передаем данные в представление
        return view('admin.units.index', compact('groupedUnits', 'manuals', 'planes', 'builders', 'scopes'));
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

        \DB::transaction(function() use ($request) {
            foreach ($request->part_numbers as $partNumber) {
                Unit::create([
                    'manuals_id' => $request->cmm_id,
                    'part_number' => $partNumber,
                ]);
            }
        });

        return response()->json(['success' => true]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $manualId)
    {
        // Убедитесь, что вы правильно получаете юниты
        $units = Unit::where('manuals_id', $manualId)->get();

        // Возвращаем данные в формате JSON
        return response()->json(['units' => $units]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($manualsId)
    {
        // Проверяем, что manual существует
        $manual = Manual::findOrFail($manualsId);

        // Получаем все units, связанные с данным manuals_id
        $units = Unit::where('manuals_id', $manualsId)->get();

        if ($units->isEmpty()) {
            return redirect()->back()->with('error', 'No units found for the selected manual.');
        }

        return view('admin.units.edit', compact('manual', 'units'));
    }

    public function getUnitsByManual($manualId)
    {
        $units = Unit::where('manuals_id', $manualId)->get();

        return response()->json([
            'units' => $units,
        ]);
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

        // Если part_number хранится как массив строк (JSON)
        // $unit->part_number = json_encode($validated['part_numbers']);

        // Если part_number - это просто строка (например, один номер детали)
        $unit->part_number = implode(',', $validated['part_numbers']);

        $unit->save();

        return response()->json([
            'success' => true,
            'message' => 'Unit updated successfully'
        ]);
    }

    public function updateUnits(Request $request, $manualId)
    {
        $manual = Manual::findOrFail($manualId);

        // Получить существующие part_numbers
        $existingPartNumbers = $manual->units()->pluck('part_number')->toArray();

        // Новые part_numbers из запроса
        $newPartNumbers = $request->input('part_numbers');

        // Удаляем те, которых нет в новых данных
        $manual->units()->whereNotIn('part_number', $newPartNumbers)->delete();

        // Добавляем новые part_numbers, которых не было
        foreach ($newPartNumbers as $partNumber) {
            if (!in_array($partNumber, $existingPartNumbers)) {
                $manual->units()->create([
                    'part_number' => $partNumber
                ]);
            }
        }

        return response()->json(['success' => true]);
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
    public function destroy(string $manualId)
    {
        // Получаем мануал по полю 'number'
        $manual = Manual::where('number', $manualId)->first();

        // Если мануал найден, удаляем связанные юниты
        if ($manual) {
            // Удаляем все юниты, связанные с выбранным мануалом
            Unit::where('manuals_id', $manual->id)->delete();

            // Перенаправляем на индекс с сообщением об успешном удалении
            return redirect()->route('admin.units.index')->with('success', 'Все юниты успешно удалены.');
        }

        // Если мануал не найден, возвращаем ошибку
        return redirect()->route('admin.units.index')->with('error', 'Мануал не найден.');
    }

//        $unit = Unit::findOrFail($id);
//        $unit->delete();
//        return redirect()->route('admin.units.index')->with('success', 'Unit has been deleted');


}
