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

test('subbab reorder endpoint updates course content order', function () {
    $user = User::factory()->create();

    $course = \App\Models\Course::create([
        'nama' => 'Materi Reorder',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Subbab 1'],
            ['type' => 'paragraf', 'teks' => 'Isi Subbab 1'],
            ['type' => 'subbab', 'judul' => 'Subbab 2'],
            ['type' => 'paragraf', 'teks' => 'Isi Subbab 2'],
        ],
    ]);

    $this->actingAs($user)
        ->postJson(route('admin.courses.subbab.reorder', $course), [
            'ids' => [2, 0],
        ])
        ->assertOk();

    $course->refresh();
    expect($course->konten[0]['judul'])->toBe('Subbab 2');
    expect($course->konten[1]['teks'])->toBe('Isi Subbab 2');
    expect($course->konten[2]['judul'])->toBe('Subbab 1');
    expect($course->konten[3]['teks'])->toBe('Isi Subbab 1');
});

test('admin course subbab page renders reorder table and drag handle', function () {
    $user = User::factory()->create();

    $course = \App\Models\Course::create([
        'nama' => 'Materi Reorder',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Subbab 1'],
            ['type' => 'subbab', 'judul' => 'Subbab 2'],
        ],
    ]);

    $this->actingAs($user)
        ->get(route('admin.courses.show', $course))
        ->assertOk()
        ->assertSee('ri-drag-move-2-line', false)
        ->assertSee(route('admin.courses.subbab.reorder', $course), false);
});
