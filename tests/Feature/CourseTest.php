<?php

use App\Http\Controllers\Admin\CourseController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('admin can create a course material', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('admin.courses.store'), [
            'nama' => 'Pengenalan Laravel',
            'desk' => 'Belajar dasar Laravel.',
        ]);

    $course = Course::where('nama', 'Pengenalan Laravel')->first();
    expect($course)->not->toBeNull();
    $response->assertRedirect(route('admin.courses.show', $course));
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
        ->assertSee(route('course.subbab', [$course, 'variabel']), false);
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

    $this->get(route('course.subbab', [$course, 'variabel']))
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

    $this->get(route('course.subbab', [$course, 'variabel']))
        ->assertOk()
        ->assertSee('Variabel')
        ->assertSee('Fungsi')
        ->assertSee(route('course.subbab', [$course, 'variabel']), false)
        ->assertSee(route('course.subbab', [$course, 'fungsi']), false);
});

test('course subbab reader separates both heading levels without numbers', function () {
    $course = Course::create([
        'nama' => 'JavaScript Dasar',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Variabel', 'judul_idn' => null],
            ['type' => 'subheading', 'teks' => 'Deklarasi'],
            ['type' => 'subheading3', 'teks' => 'Dengan const'],
        ],
    ]);

    $this->get(route('course.subbab', [$course, 'variabel']))
        ->assertOk()
        ->assertSee('<h2 id="deklarasi"', false)
        ->assertSee('<h3 id="dengan-const"', false)
        ->assertSee('border-l-2 border-blue-200', false)
        ->assertDontSee('>1.1', false)
        ->assertSee('Dengan const');
});

test('admin keeps a level 3 sub heading block when saving a subbab', function () {
    $user = User::factory()->create();
    $course = Course::create([
        'nama' => 'Pengenalan Laravel',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Routing'],
        ],
    ]);

    $this->actingAs($user)
        ->put(route('admin.courses.subbab.update', [$course, 0]), [
            'konten' => json_encode([
                ['type' => 'subbab', 'judul' => 'Routing'],
                ['type' => 'subheading', 'teks' => 'Dasar'],
                ['type' => 'subheading3', 'teks' => 'Route Model Binding'],
            ]),
            'updated_at' => $course->updated_at->timestamp,
            'original_subbab_title' => 'Routing',
            'original_subbab_position' => 0,
        ])
        ->assertRedirect();

    expect(collect($course->fresh()->konten)->pluck('type')->all())
        ->toBe(['subbab', 'subheading', 'subheading3']);
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

test('admin subbab edit form renders the block editor', function () {
    $user = User::factory()->create();
    $course = Course::create([
        'nama' => 'Pengenalan Laravel',
        'konten' => [
            ['type' => 'subbab', 'judul' => 'Apa itu Laravel?'],
        ],
    ]);

    $this->actingAs($user)
        ->get(route('admin.courses.subbab.edit', [$course, 0]))
        ->assertOk()
        ->assertSee('courseContentEditor', false)
        ->assertSee('Sisipkan blok', false);
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
    $fakeUrl = 'https://res.cloudinary.com/test-cloud/image/upload/test.webp';

    // Partial-mock CourseController so uploadImage() is intercepted.
    $controller = Mockery::mock(CourseController::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $controller->shouldReceive('uploadImage')->once()->andReturn($fakeUrl);
    $this->app->instance(CourseController::class, $controller);

    // 1x1 transparent WebP.
    $webp = base64_decode('UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=');

    $this->actingAs($user)
        ->post(route('admin.courses.upload-image'), [
            'gambar' => UploadedFile::fake()->createWithContent('gambar.webp', $webp),
        ], ['Accept' => 'application/json'])
        ->assertOk()
        ->assertJson(['url' => $fakeUrl]);
});

test('admin course create form has sort_order field', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.courses.create'))
        ->assertOk()
        ->assertSee('sort_order', false)
        ->assertSee('Urutan Tampil');
});

test('admin can store and update subbab and it appears in course show', function () {
    $user = User::factory()->create();
    $course = Course::create(['nama' => 'Materi Pemrograman Web']);

    $this->actingAs($user)
        ->post(route('admin.courses.subbab.store', $course))
        ->assertRedirect();

    $course->refresh();
    expect($course->konten)->toHaveCount(1);
    expect($course->konten[0]['type'])->toBe('subbab');

    $this->actingAs($user)
        ->put(route('admin.courses.subbab.update', [$course, 0]), [
            'konten' => json_encode([
                ['type' => 'subbab', 'judul' => 'Pengenalan HTML'],
                ['type' => 'paragraf', 'teks' => 'HTML adalah bahasa markah.'],
            ]),
        ])
        ->assertRedirect(route('admin.courses.subbab.edit', [$course, 0]));

    $course->refresh();
    expect($course->konten[0]['judul'])->toBe('Pengenalan HTML');

    $this->get(route('course.show', $course))
        ->assertOk()
        ->assertSee('Pengenalan HTML');
});
