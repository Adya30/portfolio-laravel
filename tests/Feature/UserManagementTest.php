<?php

use App\Models\User;

test('admin can access user management page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Daftar Pengguna Panel Admin')
        ->assertSee($admin->name);
});

test('admin can create a new user with role materi', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Siswa Baru',
            'email' => 'siswabaru@test.com',
            'password' => 'password123',
            'role' => 'materi',
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'siswabaru@test.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('materi');
    expect($user->isMateriOnly())->toBeTrue();
});

test('admin can edit a user details and role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $targetUser = User::factory()->create(['role' => 'materi']);

    $this->actingAs($admin)
        ->put(route('admin.users.update', $targetUser), [
            'name' => 'Updated Name',
            'email' => $targetUser->email,
            'role' => 'admin',
        ])
        ->assertRedirect(route('admin.users.index'));

    $targetUser->refresh();
    expect($targetUser->name)->toBe('Updated Name');
    expect($targetUser->role)->toBe('admin');
});

test('admin cannot delete their own account', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $admin))
        ->assertRedirect();

    expect(User::find($admin->id))->not->toBeNull();
});
