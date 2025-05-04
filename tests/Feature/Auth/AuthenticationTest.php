<?php

use App\Models\User;

test('users can authenticate using the login screen', function () {
    $user = User::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'johndoe@example.com',
        'password' => bcrypt('password'), // Assurez-vous que le mot de passe correspond
        'age' => 30,
        'gender' => 'male',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});

test('users can not authenticate with invalid password', function () {
    $user = User::create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'janedoe@example.com',
        'password' => bcrypt('password'),
        'age' => 25,
        'gender' => 'female',
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::create([
        'first_name' => 'Alice',
        'last_name' => 'Smith',
        'email' => 'alicesmith@example.com',
        'password' => bcrypt('password'),
        'age' => 28,
        'gender' => 'female',
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertNoContent();
});
