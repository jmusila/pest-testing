<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate($this->rules());

        $todo = new Todo([
            'name' => $request->get('name')
        ]);

        $todo->save();

        $data = [
            'msg' => 'Todo created successfully',
            'todo' => $this->mapTodoResponse($todo)
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $todo = $this->getTodo($id);

        if (is_null($todo)) {
            return response()->json([
                'msg' => "Todo with id {$id} not found"
            ], 404);
        }

        $data = [
            'msg' => 'Todo retrived successfully',
            'todo' => $this->mapTodoResponse($todo)
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate(($this->rules()));

        $todo = $this->getTodo($id);

        if (is_null($todo)) {
            return response()->json([
                'msg' => "Todo with id {$id} not found"
            ], 404);
        }

        $todo->update([
            'name' => $request->get('name')
        ]);

        $data = [
            'msg' => 'Todo updated successfully',
            'todo' => $this->mapTodoResponse($todo)
        ];

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $todo = $this->getTodo($id);

        if (is_null($todo)) {
            return response()->json([
                'msg' => "Todo with id {$id} not found"
            ], 404);
        }

        $todo->delete();

        $data = [
            'msg' => 'Todo deleted successfully'
        ];

        return response()->json($data, 200);
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

        return $todo;
    }

    public function mapTodoResponse($todo)
    {
        return [
            'id' => $todo->id,
            'name' => $todo->name,
            'completed' => $todo->completed
        ];
    }
}
