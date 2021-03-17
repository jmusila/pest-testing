<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can create a user', function () {
    $attributes = User::factory()->raw();
    $response = $this->postJson('api/users', $attributes);
    $response->assertStatus(201)->assertJson([
        'msg' => 'User created successfully'
    ]);
    // $this->assertDatabaseHas('users', $attributes);
});


it('cannot create a user without name', function(){
    $this->withoutExceptionHandling();
    $response = $this->postJson('/api/users', [
        'email' => 'test@gmail.com',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422)->assertJson([
        'name' => 'The name field is required'
    ]);
});