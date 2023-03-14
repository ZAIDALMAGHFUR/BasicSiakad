<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $search = $request->get('key');
            $users = User::where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
            // dd($users->toArray());
        } else {
            $users = User::where('role_id', '!=', 1 )->paginate(5);
        }

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
        if ($user::find($user->id)->mahasiswa) {
            return redirect()->route('users.index')->with([
                'message' => 'Yang Anda Pilih masih terdaftar sebagai mahasiswa, tidak dapat dihapus !',
                'alert-type' => 'warning'
            ]);
        }
        else {
            $user->delete();
            return redirect()->route('users.index')->with([
                'message' => 'berhasil di hapus !',
                'alert-type' => 'danger'
            ]);
        }
    }
    

    public function search(Request $request)
    {
        $search = $request->get('key');
        $users = User::where('name', 'LIKE', '%' . $search . '%')->where('role_id', '!=', 1 )->paginate(5);
        
        return response()->json($users);
    }
}
