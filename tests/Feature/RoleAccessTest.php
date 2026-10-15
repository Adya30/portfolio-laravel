<?php

use App\Models\User;

test('materi role user is redirected to courses when accessing admin dashboard', function () {
    $materiUser = User::factory()->create(['role' => 'materi']);

    $this->actingAs($materiUser)
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.courses.index'));
});

test('materi role user is restricted from accessing user management', function () {
    $materiUser = User::factory()->create(['role' => 'materi']);

    $this->actingAs($materiUser)
        ->get(route('admin.users.index'))
        ->assertRedirect(route('admin.courses.index'));
});

test('materi role user can access courses page', function () {
    $materiUser = User::factory()->create(['role' => 'materi']);

    $this->actingAs($materiUser)
        ->get(route('admin.courses.index'))
        ->assertOk();
});

test('user with unauthorized role gets 403 custom error page', function () {
    $unauthorizedUser = User::factory()->create(['role' => 'guest']);

    $this->actingAs($unauthorizedUser)
        ->get(route('admin.dashboard'))
        ->assertStatus(403)
        ->assertSee('Akses Ditolak')
        ->assertSee('ERROR 403')
        ->assertSee('Kembali')
        ->assertDontSee('animate-ping', false)
        ->assertDontSee('Ke Beranda')
        ->assertDontSee('Dashboard Admin')
        ->assertDontSee('AdyaHandika')
        ->assertDontSee('All rights reserved');
});

