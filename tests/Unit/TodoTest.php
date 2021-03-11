<?php

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a todo without a name field', function () {
    $response = $this->postJson('/api/todos', []);
    $response->assertStatus(422);
});

it('can create a todo', function(){
    $attributes = Todo::factory()->raw();
    $response = $this->postJson('/api/todos', $attributes);
    $response->assertStatus(201)->assertJson([
        'msg' => 'Todo created successfully'
    ]);
    $this->assertDatabaseHas('todos', $attributes);
});
