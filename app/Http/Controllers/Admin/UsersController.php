<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(UsersDataTable $id)
    {

        $users = User::all(); // или использовать пагинацию: User::paginate(10);
        return view('admin.users.index', compact('users'));



    }

    public function create()
    {
        $roles = Role::all();
        $teams = Team::all();

        return view('admin.users.create', compact('roles', 'teams'));
    }

    public function store(Request $request)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'avatar' => 'image|nullable',
            'roles_id' => 'nullable|exists:roles,id',
            'teams_id' => 'nullable|exists:teams,id',
            'phone' => 'nullable',
            'stamp' => 'nullable',
        ]);

        // Обработка изображения, если оно загружено
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars/', $avatarName, 'public');
            $validatedData['avatar'] = $avatarName;
        }

        // Хэширование пароля перед сохранением
        $validatedData['password'] = Hash::make($request->password);

        try {
            \Log::info('Создание пользователя с данными: ', $validatedData);
            User::create($validatedData);
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно создан.');
        } catch (\Exception $e) {
            \Log::error('Ошибка при создании пользователя: ', [
                'message' => $e->getMessage(),
                'data' => $validatedData,
                'trace' => $e->getTrace(),
            ]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Не удалось создать пользователя: ' . $e->getMessage()]);
        }


    }


    }
