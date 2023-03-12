<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', '=', false )->paginate(5);

        return view('users.index', compact('users'));
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

        return redirect()->route('admin.users.index')->with([
            'message' => 'berhasil di hapus !',
            'alert-type' => 'success'
        ]);
    }
}