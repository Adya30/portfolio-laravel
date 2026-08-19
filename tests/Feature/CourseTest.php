<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('admin can create a course material with content blocks', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('admin.courses.store'), [
            'nama' => 'Pengenalan Laravel',
            'desk' => 'Belajar dasar Laravel.',
            'konten' => json_encode([
                ['type' => 'subbab', 'judul' => 'Apa itu Laravel?', 'judul_idn' => 'Apa itu Laravel?'],
                ['type' => 'paragraf', 'teks' => 'Laravel adalah framework PHP.', 'teks_idn' => 'Laravel adalah framework PHP.'],
                ['type' => 'kode', 'bahasa' => 'php', 'kode' => "<?php echo 'Halo';"],
            ]),
        ])
        ->assertRedirect(route('admin.courses.index'));

    $course = Course::where('nama', 'Pengenalan Laravel')->first();
    expect($course)->not->toBeNull();
    expect($course->konten)->toBeArray()
        ->toHaveCount(3)
        ->and($course->konten[0]['type'])->toBe('subbab')
        ->and($course->konten[2]['bahasa'])->toBe('php');
});

test('course index page shows material panels', function () {
    Course::create([
        'nama' => 'Dasar-Dasar HTML & CSS',
        'desk' => 'Struktur halaman web dengan semantic HTML dan CSS.',
        'sort_order' => 1,
    ]);

    $this->get(route('course.index'))
        ->assertOk()
        ->assertSee('Dasar-Dasar HTML & CSS')
        ->assertSee('Struktur halaman web dengan semantic HTML dan CSS.');
});

test('course show page lists subbab overview with links to detail', function () {
    $course = Course::create([
        'nama' => 'JavaScript Dasar',
        'desk' => 'Variabel, fungsi, dan manipulasi DOM.',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Variabel', 'judul_idn' => 'Variabel'],
            ['type' => 'paragraf', 'teks' => 'JavaScript membuat halaman web interaktif.', 'teks_idn' => 'JavaScript membuat halaman web interaktif.'],
            ['type' => 'kode', 'bahasa' => 'javascript', 'kode' => "const nama = 'Adya';"],
        ],
    ]);

    $this->get(route('course.show', $course))
        ->assertOk()
        ->assertSee('JavaScript Dasar')
        ->assertSee('Variabel')
        ->assertSee('Daftar Subbab')
        ->assertSee(route('course.subbab', [$course, 0]), false);
});

test('course subbab detail page renders content blocks', function () {
    $course = Course::create([
        'nama' => 'JavaScript Dasar',
        'desk' => 'Variabel, fungsi, dan manipulasi DOM.',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Variabel', 'judul_idn' => 'Variabel'],
            ['type' => 'paragraf', 'teks' => 'JavaScript membuat halaman web interaktif.', 'teks_idn' => 'JavaScript membuat halaman web interaktif.'],
            ['type' => 'kode', 'bahasa' => 'javascript', 'kode' => "const nama = 'Adya';"],
        ],
    ]);

    $this->get(route('course.subbab', [$course, 0]))
        ->assertOk()
        ->assertSee('Variabel')
        ->assertSee('JavaScript membuat halaman web interaktif.')
        ->assertSee("const nama = 'Adya';")
        ->assertSee('language-javascript', false);
});

test('course subbab detail page has sidebar navigation', function () {
    $course = Course::create([
        'nama' => 'JavaScript Dasar',
        'desk' => 'Variabel, fungsi, dan manipulasi DOM.',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Variabel', 'judul_idn' => null],
            ['type' => 'subbab', 'judul' => 'Fungsi', 'judul_idn' => null],
        ],
    ]);

    $this->get(route('course.subbab', [$course, 0]))
        ->assertOk()
        ->assertSee('Variabel')
        ->assertSee('Fungsi')
        ->assertSee(route('course.subbab', [$course, 0]), false)
        ->assertSee(route('course.subbab', [$course, 1]), false);
});

test('admin show page lists the materi subbabs with editor links', function () {
    $user = User::factory()->create();
    $course = Course::create([
        'nama' => 'Pengenalan Laravel',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Apa itu Laravel?', 'judul_idn' => null],
            ['type' => 'paragraf', 'teks' => 'Penjelasan.', 'teks_idn' => null],
            ['type' => 'kode', 'bahasa' => 'php', 'kode' => 'echo 1;'],
            ['type' => 'subbab', 'judul' => 'Routing', 'judul_idn' => null],
        ],
    ]);

    $this->actingAs($user)
        ->get(route('admin.courses.show', $course))
        ->assertOk()
        ->assertSee('Apa itu Laravel?')
        ->assertSee('Routing')
        ->assertSee(route('admin.courses.subbab.edit', [$course, 0]), false)
        ->assertSee(route('admin.courses.subbab.edit', [$course, 3]), false);
});

test('admin course form renders the block editor', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.courses.create'))
        ->assertOk()
        ->assertSee('courseContentEditor', false)
        ->assertSee('Tambah Blok', false);
});

test('course pages do not include the portfolio navbar menu', function () {
    Course::create([
        'nama' => 'Dasar-Dasar HTML & CSS',
        'sort_order' => 1,
    ]);

    $this->get(route('course.index'))
        ->assertOk()
        ->assertDontSee("scrollToSection", false);
});

test('admin can upload a webp image for a content block', function () {
    $user = User::factory()->create();

    // 1x1 transparent WebP.
    $webp = base64_decode('UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=');

    $this->actingAs($user)
        ->post(route('admin.courses.upload-image'), [
            'gambar' => UploadedFile::fake()->createWithContent('gambar.webp', $webp),
        ], ['Accept' => 'application/json'])
        ->assertOk()
        ->assertJsonStructure(['url']);
});

test('admin course create form has sort_order field', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.courses.create'))
        ->assertOk()
        ->assertSee('sort_order', false)
        ->assertSee('Urutan Tampil');
});
