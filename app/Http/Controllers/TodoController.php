<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create(Request $request)
    {

    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:4'
        ];
    }
}
