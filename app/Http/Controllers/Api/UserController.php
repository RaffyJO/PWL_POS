<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);
        return response()->json($user, 201);
    }

    public function show($user)
    {
        return UserModel::where('user_id', $user)->first();
    }

    public function update(Request $request)
    {
        try {
            $user = UserModel::find(auth()->user()->user_id);

            $data = $request->only('level_id', 'username', 'nama', 'password');

            if ($request->username != $user->username) {
                $isExistUsername = UserModel::where('username', $request->username)->exists();
                if ($isExistUsername) {
                    return response(['message' => 'Username already taken'], 409);
                }
            }

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);
            return $user;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}
