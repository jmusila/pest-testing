<?php

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a todo without a name field', function () {
    $response = $this->postJson('/api/todos', []);
    $response->assertStatus(422);
});

it('can create a todo', function () {
    $attributes = Todo::factory()->raw();
    $response = $this->postJson('/api/todos', $attributes);
    $response->assertStatus(201)->assertJson([
        'msg' => 'Todo created successfully'
    ]);
    $this->assertDatabaseHas('todos', $attributes);
});

it('can fetch a single todo', function () {
    $todo = Todo::factory()->create();

    $response = $this->getJson("/api/todos/{$todo->id}");

    $data = [
        'msg' => 'Todo retrived successfully',
        'todo' => [
            'id' => $todo->id,
            'name' => $todo->name,
            'completed' => $todo->completed
        ]
    ];

    $response->assertStatus(200)->assertJson($data);
});

it('can update a todo', function () {
    $todo = Todo::factory()->created();
    $updatedTodo = ['name' => 'Upadted Todo'];
    $response = $this->putJson("/api/todos/{$todo->id}", $updatedTodo);
    $response->assertStatus(200)->assertJson([
        'msg' => 'Todo updated successfully'
    ]);
    $this->assertDatabaseHas('todos', $updatedTodo);
});

it('can delete a todo', function () {
    $todo = Todo::factory()->create();
    $response = $this->deleteJson("/api/todos/{$todo->id}");
    $response->assertStatus(200)->assertJson([
        'msg' => 'Todo deleted successfully'
    ]);
    $this->assertCount(0, Todo::all());
});

// it('cannot find unexisting todo', function(){
//     $response = $this->getJson("/api/todos/{$todo->id}");
// });
