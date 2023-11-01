<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCode;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user = new User();
        $user->fio = $request->fio;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();
        return $user;
    }

    public function get_code(User $phone)
    {
        // Сделать возврат кода
        $user_code = new UserCode();
        $user_code->code = UserCode::CodeGenerated();
        $user_code->user_id = $phone->id;
        $user_code->save();
        return $user_code;
    }

    private function delete_code(int $user_id)
    {
        $user_code = UserCode::where('user_id', $user_id)
            ->first();
        $user_code->delete();
        return $user_code;
    }

    public function auth(Request $request)
    {
        $token = null;
        $user = User::where('phone', $request->phone)->first();
        $user_code = UserCode::where('user_id', $user->id)->first();
        if ($request->code == $user_code->code)
        {
            $token = User::CreateBearerToken($user);
            $this->delete_code($user->id);
        }
        return [
            "user" => $user, 
            "access_key" => $token
        ];
    }

    public function logout(User $user)
    {
        return User::DeleteBearerToken($user);
    }
}
