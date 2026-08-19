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
