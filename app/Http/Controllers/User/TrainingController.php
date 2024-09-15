<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CMM;
use App\Models\Manual;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ;
        $trainingLists = Training::with(['manual','user'])
            ->where('user_id', auth()->id())
            ->get();

        return view('user.trainings.index', compact('trainingLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $userId = auth()->id();

        // Получаем ID юнитов, которые уже добавлены для текущего пользователя
        $addedCmmIds = Training::where('user_id', $userId)->pluck('manuals_id');

        // Получаем юниты, которые не добавлены для текущего пользователя
        $cmms = Manual::whereNotIn('id', $addedCmmIds)->get();




        return view('user.trainings.create', compact('cmms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);

        // Валидация входных данных
        $validatedData = $request->validate([
            'cmm_id' => 'required', // Убедитесь, что

        ]);

        // Добавляем текущего пользователя и выбранную единицу (CMM)
        Training::create([
            'user_id' => auth()->id(), // Добавляем текущего пользователя
            'cmms_id' => $validatedData['cmm_id'], // Добавляем выбранную
            // единицу
        ]);

        return redirect()->route('user.trainings.index')->with('success',
            'Unit added for training.');
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
