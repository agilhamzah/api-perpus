<?php

namespace App\Http\Controllers;

use App\Models\UsersM;
use Illuminate\Http\Request;
use App\Http\Resources\UsersR;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UsersC extends Controller
{
    public function index()
    {
        $user = UsersM::latest()->paginate(5);
        return new UsersR(true, 'List Data users', $user);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'nama_user' => 'required',
            'role' => 'required',
            'no_hp' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = UsersM::create([
            'username' => $request->username,
            'password' => $request->password,
            'nama_user' => $request->nama_user,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
        ]);

        return new UsersR(true, 'Data users Berhasil Ditambahkan!', $user);
    }

    public function show(UsersM $user){
        return new UsersR(true, 'Data users Ditemukan!', $user);
    }

    public function update(Request $request, UsersM $user){
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
            'nama_user' => 'required',
            'role' => 'required',
            'no_hp' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $user->update([
            'username' => $request->username,
            'password' => $request->password,
            'nama_user' => $request->nama_user,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
        ]);

        return new UsersR(true, 'Data Berhasil Diubah!', $user);
    }

    public function destroy(UsersM $user){
        Storage::delete('public/users/'.$user);

        $user->delete();

        return new UsersR(true, 'Data users Berhasil Dihapus!', null);
    }
}
