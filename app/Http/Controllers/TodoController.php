<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate($this->rules());

        $todo = Todo::create($request->get('name'));

        $data = [
            'msg' => 'Todo created successfully',
            'todo' => $this->mapTodoResponse($todo)
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {

    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:4'
        ];
    }

    public function getTodo($id)
    {
        $todo = Todo::where('id', $id)->first();

        if (is_null($todo)){
            return response()->json([
                'msg' => "Todo with id {$todo->id} not found"
            ], 404);
        }

        return $todo;
    }

    public function mapTodoResponse($todo)
    {
        return [
            'id' => $todo->id,
            'name' => $todo->name,
            'competed' => $todo->completed
        ];
    }
}
