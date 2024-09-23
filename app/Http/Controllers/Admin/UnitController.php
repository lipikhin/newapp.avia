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
        //where('active', true)
//            ->groupBy(function ($unit) {
//                return $unit->manuals ? $unit->manuals->number : 'No CMM';
//            });

        $units = Unit::with('manuals')->get()->groupBy(function ($unit) {
            return $unit->manual ? $unit->manual->number : 'No CMM';
        });

//        $units = Unit::with('manuals')->get();


        $manuals = Manual::all(); // Fetch all Manuals

        // Assuming you also need these for rendering in the view
        $planes = Plane::pluck('type', 'id');
        $builders = Builder::pluck('name', 'id');
        $scopes = Scope::pluck('scope', 'id');

        return view('admin.units.index', compact('units', 'manuals', 'planes', 'builders', 'scopes'));




//        $manuals = Manual::all(); // Получаем все записи из manuals
//        $units = Unit::with('manuals')->get(); // Получаем все units с данными из manuals
//        return view('admin.units.index', compact('units', 'manuals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'cmm_id' => 'required|exists:manuals,id',
            'part_numbers' => 'required|array|min:1',
            'part_numbers.*' => 'required|string|max:255',
        ]);

        foreach ($validated['part_numbers'] as $partNumber) {
            Unit::create([
                'part_number' => $partNumber,
                'manuals_id' => $validated['cmm_id']
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
