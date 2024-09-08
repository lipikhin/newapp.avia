<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.profile');
    }

    /**
     * Update the user's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:255',
            'stamp' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:3|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        $input = $request->only('name', 'email', 'phone', 'stamp');

        // Обновление пароля, если он указан
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар, если он есть
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Сохраняем новый аватар
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars/', $avatarName, 'public');
            $user->avatar = $avatarName;
        }

        // Сохраняем изменения пользователя
        $user->update($input);

        return redirect()->route('home.index')->with('success', 'Profile updated successfully.');
    }
}
