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

    public function edit($id)
    {
        $user = User::findOrFail($id); // Находим пользователя по его ID
        $roles = Role::all();          // Получаем все роли
        $teams = Team::all();          // Получаем все команды

        return view('admin.users.edit', compact('user', 'roles', 'teams'));
    }
    public function update(Request $request, $id)
    {
        // Находим пользователя по ID
        $user = User::findOrFail($id);

        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'roles_id' => 'required',
            'teams_id' => 'required',
            'phone' => 'nullable|string|max:20',
            'stamp' => 'nullable|string|max:255',
        ]);

        // Обновление данных пользователя
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->roles_id = $request->roles_id;
        $user->teams_id = $request->teams_id;
        $user->phone = $request->phone;
        $user->stamp = $request->stamp;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Сохранение изменений
        $user->save();

        // Перенаправление с сообщением об успешном обновлении
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
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

    public function destroy($id)
    {
        // Находим пользователя по ID
        $user = User::findOrFail($id);

        // Удаляем пользователя
        $user->delete();

        // Перенаправляем с сообщением об успехе
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }


}
