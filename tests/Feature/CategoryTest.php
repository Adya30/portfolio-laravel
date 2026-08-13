<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

test('admin can create a category', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('admin.categories.store'), ['nama' => 'Web Application'])
        ->assertRedirect(route('admin.categories.index'));

    expect(Category::where('nama', 'Web Application')->exists())->toBeTrue();
});

test('admin can assign a category when creating a project', function () {
    $user = User::factory()->create();
    $category = Category::create(['nama' => 'Web Application']);

    $this->actingAs($user)
        ->post(route('admin.projects.store'), [
            'nama' => 'Project A',
            'desk' => 'Deskripsi singkat',
            'category_id' => $category->id,
        ])
        ->assertRedirect(route('admin.projects.index'));

    expect(Project::where('nama', 'Project A')->first()->category_id)->toBe($category->id);
});

test('landing page renders the category filter buttons', function () {
    Category::create(['nama' => 'Web Application']);
    Category::create(['nama' => 'Blog']);

    $this->get(route('landing'))
        ->assertOk()
        ->assertSee('projectGallery', false)
        ->assertSee('Web Application', false)
        ->assertSee('Blog', false);
});
