<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user = new User([
            'name' => $request->get('name'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email')
        ]);

        $user->save();

        $data = [
            'msg' => 'User created successfully',
            'user' => $this->mapUserResponse($user)
        ];

        return response()->json($data, 201);
    }

    public function mapUserResponse($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }

    public function validateUser(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        return $rules;
    }
}
