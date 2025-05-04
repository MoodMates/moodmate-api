<?php

use App\Models\User;

test('can list users', function () {
    $response = $this->getJson('api/users');
    $response->assertStatus(200);
});

test('can create user', function () {
    $count = User::count();

    $response = $this->postJson('api/users', [
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'email', 'first_name', 'last_name', 'age', 'gender', 'created_at', 'updated_at']);

    expect(User::count())->toBe($count + 1);
});

test('can show user', function () {
    $user = User::create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $response = $this->getJson("api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'age' => $user->age,
            'gender' => $user->gender,
        ]);
});

test('can update user', function () {
    $user = User::create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $response = $this->putJson("api/users/{$user->id}", [
        'first_name' => 'Updated',
        'last_name' => 'Name',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'first_name' => 'Updated',
            'last_name' => 'Name',
        ]);

    $user->refresh();
    expect($user->first_name)->toBe('Updated');
    expect($user->last_name)->toBe('Name');
});

// test('can delete user', function () {
//     $user = User::create([
//         'email' => 'user@example.com',
//         'password' => bcrypt('password'),
//         'first_name' => 'John',
//         'last_name' => 'Doe',
//         'age' => 30,
//         'gender' => 'male',
//     ]);

//     $response = $this->deleteJson("api/users/{$user->id}");

//     $response->assertStatus(204);

//     expect(User::find($user->id))->toBeNull();
// });
