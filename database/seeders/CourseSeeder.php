<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'nama' => 'Pengenalan Laravel untuk Pemula',
                'nama_idn' => 'Pengenalan Laravel untuk Pemula',
                'desk' => 'Belajar dasar-dasar framework Laravel: routing, controller, view, dan Eloquent.',
                'desk_idn' => 'Belajar dasar-dasar framework Laravel: routing, controller, view, dan Eloquent.',
                'konten' => [
                    ['type' => 'subbab', 'judul' => 'Apa itu Laravel?', 'judul_idn' => 'Apa itu Laravel?'],
                    ['type' => 'paragraf', 'teks' => 'Laravel adalah framework PHP paling populer untuk membangun aplikasi web modern. Dengan ekosistem yang lengkap, Laravel membantu developer menulis kode yang bersih, ekspresif, dan mudah dirawat.', 'teks_idn' => 'Laravel adalah framework PHP paling populer untuk membangun aplikasi web modern. Dengan ekosistem yang lengkap, Laravel membantu developer menulis kode yang bersih, ekspresif, dan mudah dirawat.'],
                    ['type' => 'kode', 'bahasa' => 'bash', 'kode' => 'composer create-project laravel/laravel nama-project\ncd nama-project\nphp artisan serve'],
                    ['type' => 'subbab', 'judul' => 'Struktur Project', 'judul_idn' => 'Struktur Project'],
                    ['type' => 'paragraf', 'teks' => 'Setelah install, kamu akan melihat struktur direktori seperti berikut. Folder app berisi logic aplikasi, routes berisi definisi URL, dan resources berisi view.', 'teks_idn' => 'Setelah install, kamu akan melihat struktur direktori seperti berikut. Folder app berisi logic aplikasi, routes berisi definisi URL, dan resources berisi view.'],
                    ['type' => 'kode', 'bahasa' => 'php', 'kode' => "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', function () {\n    return view('welcome');\n});"],
                    ['type' => 'subbab', 'judul' => 'Routing & Controller', 'judul_idn' => 'Routing & Controller'],
                    ['type' => 'paragraf', 'teks' => 'Di akhir materi, kamu akan mampu membuat halaman web dinamis sederhana dengan Laravel, mulai dari routing, controller, view, hingga Eloquent ORM untuk interaksi database.', 'teks_idn' => 'Di akhir materi, kamu akan mampu membuat halaman web dinamis sederhana dengan Laravel, mulai dari routing, controller, view, hingga Eloquent ORM untuk interaksi database.'],
                ],
                'gambar' => null,
            ],
            [
                'nama' => 'Dasar-Dasar HTML & CSS',
                'nama_idn' => 'Dasar-Dasar HTML & CSS',
                'desk' => 'Memahami struktur halaman web dengan semantic HTML dan styling menggunakan CSS.',
                'desk_idn' => 'Memahami struktur halaman web dengan semantic HTML dan styling menggunakan CSS.',
                'konten' => [
                    ['type' => 'subbab', 'judul' => 'Struktur Halaman Web', 'judul_idn' => 'Struktur Halaman Web'],
                    ['type' => 'paragraf', 'teks' => 'HTML (HyperText Markup Language) adalah bahasa untuk menyusun struktur halaman web, sedangkan CSS (Cascading Style Sheets) digunakan untuk mengatur tampilannya.', 'teks_idn' => 'HTML (HyperText Markup Language) adalah bahasa untuk menyusun struktur halaman web, sedangkan CSS (Cascading Style Sheets) digunakan untuk mengatur tampilannya.'],
                    ['type' => 'kode', 'bahasa' => 'html', 'kode' => '<header>\n    <h1>Judul Halaman</h1>\n    <nav>\n        <a href="#beranda">Beranda</a>\n        <a href="#tentang">Tentang</a>\n    </nav>\n</header>\n\n<main>\n    <section id="beranda">\n        <p>Konten utama halaman.</p>\n    </section>\n</main>'],
                    ['type' => 'subbab', 'judul' => 'Layout dengan Flexbox & Grid', 'judul_idn' => 'Layout dengan Flexbox & Grid'],
                    ['type' => 'paragraf', 'teks' => 'Flexbox cocok untuk layout satu dimensi, sementara Grid untuk dua dimensi. Praktikkan dengan membuat landing page sederhana yang responsive.', 'teks_idn' => 'Flexbox cocok untuk layout satu dimensi, sementara Grid untuk dua dimensi. Praktikkan dengan membuat landing page sederhana yang responsive.'],
                ],
                'gambar' => null,
            ],
            [
                'nama' => 'JavaScript Dasar & DOM Manipulation',
                'nama_idn' => 'JavaScript Dasar & DOM Manipulation',
                'desk' => 'Memahami variabel, fungsi, event, dan cara memanipulasi DOM untuk interaktivitas.',
                'desk_idn' => 'Memahami variabel, fungsi, event, dan cara memanipulasi DOM untuk interaktivitas.',
                'konten' => [
                    ['type' => 'subbab', 'judul' => 'Variabel & Tipe Data', 'judul_idn' => 'Variabel & Tipe Data'],
                    ['type' => 'paragraf', 'teks' => 'JavaScript membuat halaman web menjadi interaktif. Semua berawal dari variabel dan tipe data.', 'teks_idn' => 'JavaScript membuat halaman web menjadi interaktif. Semua berawal dari variabel dan tipe data.'],
                    ['type' => 'kode', 'bahasa' => 'javascript', 'kode' => 'const nama = "Adya";\nlet umur = 21;\n\nconst perkenalan = `Halo, saya ${nama}, umur ${umur} tahun.`;\nconsole.log(perkenalan);'],
                    ['type' => 'subbab', 'judul' => 'Event & Manipulasi DOM', 'judul_idn' => 'Event & Manipulasi DOM'],
                    ['type' => 'paragraf', 'teks' => 'Event listener dan manipulasi DOM memungkinkan halaman merespons aksi pengguna. Selesaikan materi ini dengan membuat aplikasi todo sederhana.', 'teks_idn' => 'Event listener dan manipulasi DOM memungkinkan halaman merespons aksi pengguna. Selesaikan materi ini dengan membuat aplikasi todo sederhana.'],
                    ['type' => 'kode', 'bahasa' => 'javascript', 'kode' => "document.querySelector('#btn').addEventListener('click', () => {\n    const item = document.querySelector('#input').value;\n    const li = document.createElement('li');\n    li.textContent = item;\n    document.querySelector('#list').appendChild(li);\n});"],
                ],
                'gambar' => null,
            ],
            [
                'nama' => 'Pengenalan Database dengan MySQL',
                'nama_idn' => 'Pengenalan Database dengan MySQL',
                'desk' => 'Konsep database relasional, normalisasi, dan query SQL dasar hingga lanjutan.',
                'desk_idn' => 'Konsep database relasional, normalisasi, dan query SQL dasar hingga lanjutan.',
                'konten' => [
                    ['type' => 'subbab', 'judul' => 'Database Relasional', 'judul_idn' => 'Database Relasional'],
                    ['type' => 'paragraf', 'teks' => 'Database adalah tempat menyimpan data secara terstruktur. Konsep kunci-nya adalah tabel, primary key, dan foreign key untuk menghubungkan data.', 'teks_idn' => 'Database adalah tempat menyimpan data secara terstruktur. Konsep kunci-nya adalah tabel, primary key, dan foreign key untuk menghubungkan data.'],
                    ['type' => 'kode', 'bahasa' => 'sql', 'kode' => 'CREATE TABLE produk (\n    id INT PRIMARY KEY AUTO_INCREMENT,\n    nama VARCHAR(100) NOT NULL,\n    harga DECIMAL(10,2)\n);\n\nINSERT INTO produk (nama, harga) VALUES (\'Kopi Arabika\', 25000);\n\nSELECT p.nama, p.harga\nFROM produk p\nWHERE p.harga > 10000\nORDER BY p.harga DESC;'],
                    ['type' => 'subbab', 'judul' => 'Normalisasi Database', 'judul_idn' => 'Normalisasi Database'],
                    ['type' => 'paragraf', 'teks' => 'Latih dengan merancang skema database untuk sistem sederhana seperti toko online, lalu terapkan normalisasi untuk menghindari data duplikat.', 'teks_idn' => 'Latih dengan merancang skema database untuk sistem sederhana seperti toko online, lalu terapkan normalisasi untuk menghindari data duplikat.'],
                ],
                'gambar' => null,
            ],
        ];

        foreach ($courses as $i => $course) {
            $slug = Str::slug($course['nama']);
            $courseData = $course + [
                'slug' => $slug,
                'sort_order' => $i + 1,
            ];

            Course::updateOrCreate(
                ['nama' => $course['nama']],
                $courseData
            );
        }
    }
}
