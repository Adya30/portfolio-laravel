<?php

use App\Models\Tool;
use App\Models\User;

test('reorder endpoint updates sort_order', function () {
    $user = User::factory()->create();

    $tools = collect([1, 2, 3])->map(fn ($i) => Tool::create([
        'nama' => "Tool $i",
        'ket' => null,
        'sort_order' => $i,
    ]));
    $ids = $tools->pluck('id')->all();
    $reversed = array_reverse($ids);

    $this->actingAs($user)
        ->postJson(route('admin.tools.reorder'), ['ids' => $reversed])
        ->assertOk();

    expect(Tool::orderBy('sort_order')->pluck('id')->all())->toBe($reversed);
});

test('tools index renders the drag handle', function () {
    $user = User::factory()->create();
    Tool::create(['nama' => 'Laravel', 'ket' => 'Framework', 'sort_order' => 1]);

    $this->actingAs($user)
        ->get(route('admin.tools.index'))
        ->assertOk()
        ->assertSee('ri-drag-move-2-line', false)
        ->assertSee('reorderTable', false)
        ->assertDontSee('name="sort_order"', false);
});
