<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

$base_url = 'api/users';

it('can create a user', function () use ($base_url) {
    $test_user = User::factory()->raw();
    $response = $this->postJson("{$base_url}", $test_user);
    $response->assertStatus(201)->assertJson([
        'msg' => 'User created successfully'
    ]);
    $this->assertDatabaseHas('users', ['id' => 1]);
});


it('cannot create a user without name', function () use($base_url) {
    $response = $this->postJson("{$base_url}", [
        'email' => 'test@gmail.com',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422);
});

it('cannot create a user without email', function () {
    $response = $this->postJson('api/users', [
        'name' => 'testName',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422);
});

it('cannot create a user without password', function () {
    $response = $this->postJson('api/users', [
        'email' => 'test@gmail.com',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422);
});

it('cannot create a user with duplicate email', function () {
    $attributes = [
        'name' => 'John Doe',
        'email' => 'test@johndoe.com',
        'password' => 'Password'
    ];
    $response = $this->postJson('api/users', $attributes);
    $response->assertStatus(201)->assertJson([
        'msg' => 'User created successfully'
    ]);
    $response2 = $this->postJson('api/users', $attributes);
    $response2->assertStatus(422);
});
