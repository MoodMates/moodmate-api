<?php

use App\Models\Quote;
use App\Models\User;

test('can list quotes', function () {
    $response = $this->getJson('api/quotes');
    $response->assertStatus(200);
});

test('can create quote', function () {
    $user = User::create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $response = $this->postJson('api/quotes', [
        'quote_text' => 'This is a test quote.',
        'user_id' => $user->id,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'quote_text', 'user_id', 'created_at', 'updated_at']);
});

test('can show quote', function () {
    $user = User::create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $quote = Quote::create(['quote_text' => 'This is a test quote.', 'user_id' => $user->id]);

    $response = $this->getJson("api/quotes/{$quote->id}");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $quote->id,
            'quote_text' => $quote->quote_text,
            'user_id' => $quote->user_id,
        ]);
});

test('can update quote', function () {
    $user = User::create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => 30,
        'gender' => 'male',
    ]);

    $quote = Quote::create(['quote_text' => 'This is a test quote.', 'user_id' => $user->id]);

    $response = $this->putJson("api/quotes/{$quote->id}", [
        'quote_text' => 'Updated quote text.',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'id' => $quote->id,
            'quote_text' => 'Updated quote text.',
        ]);
});

// test('can delete quote', function () {
//     $user = User::create([
//         'email' => 'user@example.com',
//         'password' => bcrypt('password'),
//         'first_name' => 'John',
//         'last_name' => 'Doe',
//         'age' => 30,
//         'gender' => 'male',
//     ]);

//     $quote = Quote::create(['quote_text' => 'This is a test quote.', 'user_id' => $user->id]);

//     $response = $this->deleteJson("api/quotes/{$quote->id}");

//     $response->assertStatus(204);

//     expect(Quote::find($quote->id))->toBeNull();
// });
