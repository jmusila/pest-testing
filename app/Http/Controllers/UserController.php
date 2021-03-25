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
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 422);
        }
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

    public function show($id){
        $user = $this->getUser($id);

        if (is_null($user)) {
            return response()->json([
                'msg' => "User with id {$id} not found"
            ], 404);
        }

        $data = [
            'msg' => 'User retrived successfully',
            'data' => $this->mapUserResponse($user)
        ];
        return response()->json($data, 200);
    }

    public function mapUserResponse($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }

    public function getUser($id){
        $user = User::where('id', $id)->first();

        return $user;
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
