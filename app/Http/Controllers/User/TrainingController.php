<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Manual;
use App\Models\Training;
use App\Models\User;
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
        // Получаем тренировки пользователя с учётом руководства
        $trainingLists = auth()->user()->trainings()->with('manual')->get()->groupBy('manuals_id');

        // Обрабатываем группы тренировок для установки дат
        $formattedTrainingLists = [];
        foreach ($trainingLists as $manualId => $trainings) {
            // Сортируем тренировки по дате
            $sortedTrainings = $trainings->sortBy('date_training');

            // Получаем самую раннюю и самую позднюю даты
            $firstTraining = $sortedTrainings->first();
            $lastTraining = $sortedTrainings->last();

            // Добавляем данные в массив
            $formattedTrainingLists[] = [
                'manuals_id' => $manualId,
                'first_training' => $firstTraining,
                'last_training' => $lastTraining,
            ];
        }

        return view('user.trainings.index', compact('formattedTrainingLists'));
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
        $manuals = Manual::whereNotIn('id', $addedCmmIds)->get();

        return view('user.trainings.create', compact('manuals'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Получение значения manual из запроса
        $manual = $request->input('manual');

        // Получение ID текущего пользователя
        $userId = auth()->id();
        $form_type = 112;

        // Выполнение поиска по таблице trainings
        if (Training::where('user_id', $userId)->where('manuals_id', $manual)->first()) {
            $form_type = 132;
        }

        // Валидация входных данных
        $validatedData = $request->validate([
            'manuals_id' => 'required',
            'date_training' => 'nullable|date'
        ]);

        // Устанавливаем дату тренировки для формы 132
        $dateTraining132 = $validatedData['date_training'];

        // Если тип формы не 132, создаем еще одну запись для формы 132
        if ($form_type != 132) {
            Training::create([
                'user_id' => $userId, // Текущий пользователь
                'manuals_id' => $validatedData['manuals_id'],
                'date_training' => $dateTraining132,
                'form_type' => 132,
            ]);
        }

        // Вычисление даты для формы 112
        $dateTraining112 = \Carbon\Carbon::parse($dateTraining132)
            ->next(\Carbon\Carbon::FRIDAY); // Находим следующую пятницу

        // Создаем запись для формы 112
        Training::create([
            'user_id' => $userId, // Текущий пользователь
            'manuals_id' => $validatedData['manuals_id'],
            'date_training' => $dateTraining112,
            'form_type' => 112,
        ]);

        return redirect()->route('user.trainings.index')->with('success', 'Unit added for training.');
    }
    public function createTrainings(Request $request, $id)
    {
       dd($request,$id);
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
