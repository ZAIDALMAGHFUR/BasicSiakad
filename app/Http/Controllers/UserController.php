<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1 )->paginate(5);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get(['id', 'name'])->where('id', '!=', 1);
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with([
            'message' => 'berhasil di buat !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $user->update(request()->all());

        return redirect()->route('users.index')->with([
            'message' => 'berhasil di update !',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with([
            'message' => 'berhasil di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}