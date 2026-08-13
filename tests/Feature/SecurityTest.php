<?php

use App\Models\User;

test('responses include security headers', function () {
    $this->get(route('landing'))
        ->assertOk()
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

test('login is locked after too many failed attempts', function () {
    $user = User::factory()->create(['password' => 'secret-password']);

    foreach (range(1, 5) as $i) {
        $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    $this->post(route('login.attempt'), [
        'email' => $user->email,
        'password' => 'secret-password',
    ])->assertSessionHasErrors('email');
});

test('successful login regenerates the session and redirects to admin', function () {
    $user = User::factory()->create(['password' => 'secret-password']);

    $this->post(route('login.attempt'), [
        'email' => $user->email,
        'password' => 'secret-password',
    ])->assertRedirect(route('admin.dashboard'));

    expect(auth()->check())->toBeTrue();
});
