<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

$base_url = 'api/users';

$test_user = [
    'name' => 'Jonh Doe',
    'email' => 'johndoe@test.com',
    'email_verified_at' => null,
    'password' => 'password',
    'remember_token' => null,
    'created_at' => Carbon::now(config('app.timezone')),
    'updated_at' => Carbon::now()
];

it('can create a user', function () use($base_url, $test_user) {
    // $attributes = User::factory()->raw();
    $response = $this->postJson("{$base_url}", $test_user);
    $response->assertStatus(201)->assertJson([
        'msg' => 'User created successfully'
    ]);
    $this->assertDatabaseHas('users', $test_user);
});


it('cannot create a user without name', function () {
    $response = $this->postJson('/api/users', [
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

it('cannot create a user with duplicate email', function(){
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
