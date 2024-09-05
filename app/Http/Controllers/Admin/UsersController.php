<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $id)
    {

        $user = User::findOrFail($id);


        return view('admin.users.index', compact('user'));


//        return $dataTable->render('admin.users.index');
    }

//    public function updateRole(Request $request, $id)
//    {
//        $user = User::findOrFail($id);
//        $user->roles()->sync([$request->input('role_id')]);
//
//        return response()->json(['success' => 'Role updated successfully']);
//    }
//
//    public function updateTeam(Request $request, $id)
//    {
//        $user = User::findOrFail($id);
//        $user->teams_id = $request->input('team_id');
//        $user->save();
//
//        return response()->json(['success' => 'Team updated successfully']);
//    }
//    public function updateAvatar(Request $request)
//    {
//        $request->validate([
//            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        $user = User::findOrFail($request->user_id);
//
//        if ($request->hasFile('avatar')) {
//            $avatarName = time().'.'.$request->avatar->extension();
//            $request->avatar->move(public_path('avatars'), $avatarName);
//            $user->avatar = $avatarName;
//            $user->save();
//        }
//
//        return redirect()->route('admin.users.index')->with('success', 'Аватар успешно обновлен');
//    }

}
