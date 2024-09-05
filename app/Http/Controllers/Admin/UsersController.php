<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
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
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'image|nullable',
            'roles_id' => 'nullable|exists:roles,id',
            'teams_id' => 'nullable|exists:teams,id',
            'phone' => 'nullable',
            'stamp' => 'nullable',
        ]);

        // Проверка аватара
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars/', $avatarName, 'public');
            $validatedData['avatar'] = $avatarName;
        }

        try {
            User::create($validatedData);
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно создан.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Не удалось создать пользователя: ' . $e->getMessage()]);
        }
    }



}
