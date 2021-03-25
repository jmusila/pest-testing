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

it('cannot create a user without email', function () use($base_url) {
    $response = $this->postJson("{$base_url}", [
        'name' => 'testName',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422);
});

it('cannot create a user without password', function () use($base_url) {
    $response = $this->postJson("{$base_url}", [
        'email' => 'test@gmail.com',
        'password' => 'testPass'
    ]);
    $response->assertStatus(422);
});

it('cannot create a user with duplicate email', function () use($base_url){
    $attributes = [
        'name' => 'John Doe',
        'email' => 'test@johndoe.com',
        'password' => 'Password'
    ];
    $response = $this->postJson("{$base_url}", $attributes);
    $response->assertStatus(201)->assertJson([
        'msg' => 'User created successfully'
    ]);
    $response2 = $this->postJson("{$base_url}", $attributes);
    $response2->assertStatus(422);
});

it('can fetch a single users', function() use($base_url){
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $response = $this->getJson("{$base_url}/{$user->id}");

    $data = [
        'msg' => 'User retrived successfully',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]
    ];

    $response->assertStatus(200)->assertJson($data);
});
