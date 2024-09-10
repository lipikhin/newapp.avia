<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirCraft;
use App\Models\CMM;
use App\Models\MFR;
use App\Models\Scope;
use Illuminate\Http\Request;

class CmmController extends Controller
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

        $cmms = Cmm::with(['airCraft', 'mfr', 'scope'])->get(); // Загружаем
        // связанные модели
        return view('admin.cmms.index', compact('cmms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $airCrafts = AirCraft::all();
        $mfrs = Mfr::all();
        $scopes = Scope::all();

        return view('admin.cmms.create', compact('airCrafts', 'mfrs', 'scopes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            // Валидация входящих данных
            $validatedData = $request->validate([
                'number' => 'required',
                'title' => 'required',
                'img' => 'image|nullable',
                'revision_date' => 'required',
                'units_pn'=>'nullable',
                'air_crafts_id' => 'required|exists:air_crafts,id',
                'm_f_r_s_id' => 'required|exists:m_f_r_s,id',
                'scopes_id' => 'required|exists:scopes,id',
                'lib' => 'required'
            ]);

            // Если изображение присутствует в запросе
            if ($request->hasFile('img')) {
                // Генерация уникального имени для файла изображения
                $imgName = time() . '.' . $request->img->getClientOriginalExtension();
                // Перемещение изображения в директорию storage/app/public/image/cmm
                $request->img->storeAs('image/cmm', $imgName, 'public');
                // Добавление имени файла изображения в массив данных для создания записи
                $validatedData['img'] = $imgName;
            }

            try {

                // Создание новой записи в базе данных
                CMM::create($validatedData);
                // Перенаправление пользователя на страницу со списком CMM с сообщением об успешном создании
                return redirect()->route('admin.cmms.index')->with('success', 'Инструкция успешно создана.');
            } catch (\Exception $e) {
                // Обработка ошибки при вставке данных в базу данных
                return redirect()->back()->withInput()->withErrors(['error' => 'Не удалось создать инструкцию: ' . $e->getMessage()]);
            }
        }
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

    // Edit method
    public function edit($id)
    {
        $cmm = Cmm::findOrFail($id);
        $airCrafts = AirCraft::all(); // Получаем все записи из таблицы AirCraft
        $mfrs = Mfr::all(); // Получаем все записи из таблицы MFR
        $scopes = Scope::all(); // Получаем все записи из таблицы Scope

        return view('admin.cmms.edit', compact('cmm', 'airCrafts', 'mfrs', 'scopes'));
    }


// Update method
    public function update(Request $request, $id)
    {
        $cmm = Cmm::findOrFail($id);

        // Пример валидации, добавьте свои правила
        $request->validate([
            'number' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            // Добавьте другие поля по мере необходимости
        ]);

        $cmm->update($request->all());
        return redirect()->route('admin.cmms.index')->with('success', 'CMM updated successfully');
    }


// Destroy method
    public function destroy($id)
    {
        $cmm = Cmm::findOrFail($id);
        $cmm->delete();
        return redirect()->route('admin.cmms.index')->with('success', 'CMM deleted successfully');
    }

//    public function edit(string $id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id)
//    {
//        //
//    }
}
