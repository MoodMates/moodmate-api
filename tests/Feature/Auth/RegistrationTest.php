<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'age' => 30,
        'gender' => 'male',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'email', 'first_name', 'age', 'gender', 'last_name', 'created_at', 'updated_at']);

    $this->assertAuthenticated();
});
