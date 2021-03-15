<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can create a user', function (){
    $attributes = User::factory()->raw();
    $response = $this->postJson('api/users', $attributes);
    $response->assertStatus(200)->assertJson([
        'msg' => 'User created successfully'
    ]);
    $this->assertDatabaseHas('users', $attributes);
});