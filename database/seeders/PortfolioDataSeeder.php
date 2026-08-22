<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioDataSeeder extends Seeder
{
    /** Maps project names to their category ids (filled by seedCategories). */
    private array $categoryByProject = [];

    /**
     * Seed the portfolio content (projects, tools, certificates, experiences, profile).
     */
    public function run(): void
    {
        $this->seedProfile();
        $this->seedTools();
        $this->seedCategories();
        $this->seedProjects();
        $this->seedExperiences();
        $this->seedCertificates();
    }

    private function seedCategories(): void
    {
        $groups = [
            'Web Application' => ['Agris', 'Handman', 'Kasirku'],
            'Frontend / UI Design' => ['Iphone UI', 'Fire Force', 'Gorengin Aja!'],
            'Blog' => ['SMAGITV Blog', 'Adya Blog'],
            'Software' => ['Tanamin', 'GARAP', 'SIPA'],
            'Database' => ['SINABIL'],
        ];

        foreach ($groups as $nama => $projectNames) {
            $category = Category::updateOrCreate(['nama' => $nama]);
            foreach ($projectNames as $projectName) {
                $this->categoryByProject[$projectName] = $category->id;
            }
        }
    }

    private function seedProfile(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Adya Handika Putra AP',
                'role_title' => 'Web Developer | UI Design',
                'role_title_idn' => 'Web Developer | Desain UI',
                'tagline' => 'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.',
                'tagline_idn' => 'Mendesain UI untuk website, membangun aplikasi web modular dengan fokus pada arsitektur dan pengalaman digital yang presisi.',
                'about_1' => "Hello! I'm Adya Handika Putra AP, a Full Stack Developer with a deep passion for technology, open source, and exploring new programming concepts to build digital solutions that are both functional and precisely crafted.",
                'about_1_idn' => "Halo! Saya Adya Handika Putra AP, seorang Full Stack Developer dengan ketertarikan mendalam pada teknologi, open source, dan eksplorasi konsep pemrograman baru untuk membangun solusi digital yang fungsional dan dibuat dengan presisi.",
                'about_2' => "Currently pursuing a degree in Information Systems at the University of Jember, I'm constantly driven to learn, create, and contribute to the developer community through clean code, thoughtful architecture, and collaborative projects.",
                'about_2_idn' => "Saat ini saya menempuh pendidikan di jurusan Sistem Informasi Universitas Jember. Saya terus terdorong untuk belajar, berkarya, dan berkontribusi pada komunitas developer melalui kode yang bersih, arsitektur yang matang, dan proyek kolaboratif.",
                'email' => 'handikaadya@gmail.com',
                'cv_url' => 'https://drive.google.com/file/d/1yxphIQqnXRANWjzAER0K194RBqvTg3We/view?usp=sharing',
                'hero_image' => null,
                'github' => 'https://github.com/Adya30/',
                'instagram' => 'https://www.instagram.com/adya_han/',
                'youtube' => 'https://www.youtube.com/@AdyaHandika',
                'linkedin' => 'https://www.linkedin.com/in/adya-handika/',
            ]
        );
    }

    private function seedTools(): void
    {
        $tools = [
            ['Visual Studio Code', 'Code Editor', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg'],
            ['HTML 5', 'Structure', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
            ['CSS 3', 'Style', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg'],
            ['Javascript', 'Language', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'],
            ['Tailwind CSS', 'Framework', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg'],
            ['Bootstrap', 'Framework', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg'],
            ['Postgre SQL', 'Database', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg'],
            ['Python', 'Language', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg'],
            ['React JS', 'Framework', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'],
            ['Github', 'Repository', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg'],
            ['Canva', 'Design Tool', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/canva/canva-original.svg'],
            ['Figma', 'Design Tool', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg'],
            ['C#', 'Language', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg'],
            ['Laravel', 'Framework', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg'],
            ['MySQL', 'Database', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'],
            ['PHP', 'Language', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'],
        ];

        foreach ($tools as $i => [$nama, $ket, $gambar]) {
            Tool::updateOrCreate(
                ['nama' => $nama],
                ['ket' => $ket, 'gambar' => $gambar, 'sort_order' => $i + 1]
            );
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'nama' => 'Agris',
                'desk' => 'E-commerce and partnership platform for agriculture built with Laravel 13 and Tailwind CSS v4.',
                'desk_idn' => 'Platform e-commerce dan kemitraan pertanian yang dibangun dengan Laravel 13 dan Tailwind CSS v4.',
                'full_desk' => 'AGRIS is a modern agroindustrial e-commerce and partnership platform connecting agricultural producers with distribution partners (agents). Built with Laravel 13 and Tailwind CSS v4, it integrates Midtrans, Biteship, Wilayah.id, and Google OAuth to deliver a secure, automated, and real-time shopping, logistics, and digital payment experience.',
                'full_desk_idn' => 'AGRIS adalah platform e-commerce dan kemitraan agroindustri modern yang menghubungkan produsen pertanian dengan mitra distribusi (agen). Dibangun dengan Laravel 13 dan Tailwind CSS v4, terintegrasi dengan Midtrans, Biteship, Wilayah.id, dan Google OAuth untuk menghadirkan pengalaman belanja, logistik, dan pembayaran digital yang aman, otomatis, dan real-time.',
                'link' => 'https://github.com/Adya30/Agris',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Admin & Agent Partnerships', 'Midtrans Payment Gateway', 'Biteship Logistics Integration', 'Google OAuth & OTP Verification', 'Wilayah.id Administrative Subdivisions'],
                'fitur_idn' => ['Kemitraan Admin & Agen', 'Payment Gateway Midtrans', 'Integrasi Logistik Biteship', 'Google OAuth & Verifikasi OTP', 'Pembagian Wilayah Administratif Wilayah.id'],
                'gambar' => null,
            ],
            [
                'nama' => 'Handman',
                'desk' => 'Office task management and collaboration platform with real-time tracking and scheduling.',
                'desk_idn' => 'Platform manajemen tugas kantor dan kolaborasi internal dengan pelacakan dan penjadwalan real-time.',
                'full_desk' => 'HANDMAN is an office task management and company internal collaboration platform designed to improve team workflow efficiency. Featuring Admin, Manager, and Staff roles, the app supports real-time task delegation, operational issue ticketing, interactive work agendas, and dynamic PDF report exports with filters.',
                'full_desk_idn' => 'HANDMAN adalah platform manajemen tugas kantor dan kolaborasi internal perusahaan yang dirancang untuk meningkatkan efisiensi alur kerja tim. Dengan peran Admin, Manager, dan Staff, aplikasi ini mendukung delegasi tugas real-time, tiket penanganan masalah operasional, agenda kerja interaktif, dan ekspor laporan PDF dinamis dengan filter.',
                'link' => 'https://github.com/Adya30/HANDMAN',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Real-Time Task Delegation', 'Work Agenda Calendar', 'Issue Ticketing System', 'Filtered PDF Report Export', 'Role-Based Access Control'],
                'fitur_idn' => ['Delegasi Tugas Real-Time', 'Kalender Agenda Kerja', 'Sistem Tiket Masalah', 'Ekspor Laporan PDF dengan Filter', 'Kontrol Akses Berbasis Peran'],
                'gambar' => null,
            ],
            [
                'nama' => 'Kasirku',
                'desk' => 'Web-based cashier/POS (Point of Sale) system for managing sales transactions and inventory.',
                'desk_idn' => 'Sistem kasir/POS (Point of Sale) berbasis web untuk mengelola transaksi penjualan dan inventaris.',
                'full_desk' => 'Kasirku is a web-based cashier and Point of Sale (POS) system built using Laravel, PHP, and MySQL. It helps small businesses manage sales transactions, track product inventory, and generate digital transaction records in real-time.',
                'full_desk_idn' => 'Kasirku adalah sistem kasir dan Point of Sale (POS) berbasis web yang dibangun menggunakan Laravel, PHP, dan MySQL. Membantu usaha kecil mengelola transaksi penjualan, melacak inventaris produk, dan membuat catatan transaksi digital secara real-time.',
                'link' => 'https://github.com/Adya30/Kasirku',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Point of Sale (POS)', 'Inventory Management', 'Transaction History', 'Real-Time Calculation'],
                'fitur_idn' => ['Point of Sale (POS)', 'Manajemen Inventaris', 'Riwayat Transaksi', 'Perhitungan Real-Time'],
                'gambar' => null,
            ],
            [
                'nama' => 'Tanamin',
                'desk' => 'Agriculture and plant growth monitoring platform developed with C#, .NET, and PostgreSQL.',
                'desk_idn' => 'Platform pemantauan pertumbuhan tanaman dan manajemen pertanian yang dikembangkan dengan C#, .NET, dan PostgreSQL.',
                'full_desk' => 'Tanamin is a plant growth monitoring and agricultural management platform built using C#, .NET, and PostgreSQL. It helps users track planting schedules, monitor growth progress, and manage crop health.',
                'full_desk_idn' => 'Tanamin adalah platform pemantauan pertumbuhan tanaman dan manajemen pertanian yang dibangun menggunakan C#, .NET, dan PostgreSQL. Membantu pengguna melacak jadwal tanam, memantau perkembangan pertumbuhan, dan mengelola kesehatan tanaman.',
                'link' => 'https://github.com/Adya30/Project-Tanamin',
                'tools' => ['C#', 'PostgreSQL', '.Net'],
                'fitur' => ['Plant Growth Tracker', 'Planting Schedule', 'Database Integration', 'Health Monitoring'],
                'fitur_idn' => ['Pelacak Pertumbuhan Tanaman', 'Jadwal Penanaman', 'Integrasi Database', 'Pemantauan Kesehatan'],
                'gambar' => null,
            ],
            [
                'nama' => 'Iphone UI',
                'desk' => 'Website UI slicing replica of Apple iPhone official website using vanilla CSS and JavaScript.',
                'desk_idn' => 'Rekayasa ulang (UI slicing) website resmi Apple iPhone menggunakan CSS vanilla dan JavaScript.',
                'full_desk' => 'A frontend UI slicing project of the Apple iPhone official website. Built using clean HTML, external CSS, and vanilla JS with a mobile-first responsive design, flexbox/grid layout, and Animate On Scroll (AOS) libraries.',
                'full_desk_idn' => 'Proyek UI slicing frontend dari website resmi Apple iPhone. Dibangun menggunakan HTML yang bersih, CSS eksternal, dan vanilla JS dengan desain responsif mobile-first, layout flexbox/grid, serta pustaka Animate On Scroll (AOS).',
                'link' => 'https://github.com/Adya30/Iphone-UI',
                'tools' => ['HTML', 'CSS', 'JavaScript', 'Aos'],
                'fitur' => ['Mobile-First Responsive', 'Navbar Toggle DOM', 'Flexbox & Grid Layout', 'AOS Scroll Animation'],
                'fitur_idn' => ['Responsif Mobile-First', 'Toggle Navbar DOM', 'Layout Flexbox & Grid', 'Animasi Scroll AOS'],
                'gambar' => null,
            ],
            [
                'nama' => 'Fire Force',
                'desk' => 'A responsive anime landing page or character gallery built with HTML, CSS, JavaScript, and Bootstrap.',
                'desk_idn' => 'Landing page anime atau galeri karakter responsif yang dibangun dengan HTML, CSS, JavaScript, dan Bootstrap.',
                'full_desk' => 'Fire Force is a frontend landing page dedicated to the Fire Force anime series. Developed using HTML, CSS, JavaScript, and Bootstrap, the project features a responsive character gallery, lore explanations, and interactive visual elements.',
                'full_desk_idn' => 'Fire Force adalah landing page frontend yang didedikasikan untuk serial anime Fire Force. Dikembangkan menggunakan HTML, CSS, JavaScript, dan Bootstrap, proyek ini menampilkan galeri karakter responsif, penjelasan alur cerita, dan elemen visual interaktif.',
                'link' => 'https://github.com/Adya30/Fire-Force',
                'tools' => ['HTML', 'CSS', 'Javascript', 'Bootstrap'],
                'fitur' => ['Responsive Layout', 'Character Gallery', 'Anime Information Hub', 'Interactive DOM Elements'],
                'fitur_idn' => ['Layout Responsif', 'Galeri Karakter', 'Pusat Informasi Anime', 'Elemen DOM Interaktif'],
                'gambar' => null,
            ],
            [
                'nama' => 'Gorengin Aja!',
                'desk' => 'Online fritter ordering platform for the Mastrip area built with basic web technologies.',
                'desk_idn' => 'Platform pemesanan gorengan online untuk kawasan Mastrip yang dibangun dengan teknologi web dasar.',
                'full_desk' => 'Gorengin Aja! is an online fritter ordering platform built for Mastrip area vendors. Developed using vanilla HTML, CSS, and JavaScript, the application allows customers to browse the menu and place orders digitally.',
                'full_desk_idn' => 'Gorengin Aja! adalah platform pemesanan gorengan online yang dibangun untuk penjual di kawasan Mastrip. Dikembangkan menggunakan vanilla HTML, CSS, dan JavaScript, aplikasi ini memungkinkan pelanggan melihat menu dan melakukan pemesanan secara digital.',
                'link' => 'https://github.com/Adya30/gorengan_template',
                'tools' => ['HTML', 'CSS', 'Javascript'],
                'fitur' => ['Menu Catalog', 'Ordering System', 'Responsive Design'],
                'fitur_idn' => ['Katalog Menu', 'Sistem Pemesanan', 'Desain Responsif'],
                'gambar' => null,
            ],
            [
                'nama' => 'SMAGITV Blog',
                'desk' => 'Online magazine and news blog for SMAN 1 Giri built on the Blogger platform.',
                'desk_idn' => 'Majalah dan blog berita online SMAN 1 Giri yang dibangun di platform Blogger.',
                'full_desk' => 'SMAGITV Blog is the online magazine and journal portal for SMAN 1 Giri. Built on the Blogger platform with custom HTML and CSS styling, it serves as a central news and activities portal for the school.',
                'full_desk_idn' => 'SMAGITV Blog adalah portal majalah dan jurnal online SMAN 1 Giri. Dibangun di platform Blogger dengan styling HTML dan CSS kustom, berfungsi sebagai pusat berita dan kegiatan sekolah.',
                'link_live' => 'https://majalahonlinesman1giri.blogspot.com/',
                'tools' => ['HTML', 'CSS', 'Blogger'],
                'fitur' => ['School News', 'Activity Gallery', 'Educational Articles'],
                'fitur_idn' => ['Berita Sekolah', 'Galeri Kegiatan', 'Artikel Edukasi'],
                'gambar' => null,
            ],
            [
                'nama' => 'Adya Blog',
                'desk' => 'Personal blog containing professional ethics resumes and articles built with Blogger.',
                'desk_idn' => 'Blog pribadi berisi resume etika profesi dan artikel yang dibangun dengan Blogger.',
                'full_desk' => 'Adya Blog is a personal blog containing resumes and articles about professional ethics in information technology. Built on the Blogger platform with layout customization.',
                'full_desk_idn' => 'Adya Blog adalah blog pribadi berisi resume dan artikel tentang etika profesi di bidang teknologi informasi. Dibangun di platform Blogger dengan kustomisasi layout.',
                'link_live' => 'https://adyahan1.blogspot.com',
                'tools' => ['HTML', 'CSS', 'Blogger'],
                'fitur' => ['Blog Articles', 'Post Categories', 'Responsive Layout'],
                'fitur_idn' => ['Artikel Blog', 'Kategori Postingan', 'Layout Responsif'],
                'gambar' => null,
            ],
            [
                'nama' => 'SINABIL',
                'desk' => 'Database and relational tables design of the SINABIL Catering Information System.',
                'desk_idn' => 'Desain database dan tabel relasional Sistem Informasi Katering SINABIL.',
                'full_desk' => 'SINABIL is a database system for catering management. Developed using Python and PostgreSQL, it features relational database design with tables for orders, customers, menu, and financial reports.',
                'full_desk_idn' => 'SINABIL adalah sistem database untuk manajemen katering. Dikembangkan menggunakan Python dan PostgreSQL, menampilkan desain database relasional dengan tabel untuk pesanan, pelanggan, menu, dan laporan keuangan.',
                'link_live' => 'https://docs.google.com/document/d/18WRWZXAJY-URu0uZjnjDEM4nNbl70Gbgjl6FYmt7pg0/edit?usp=sharing',
                'tools' => ['Python', 'PostgreSQL'],
                'fitur' => ['Relational Database', 'Order Management', 'Financial Reports'],
                'fitur_idn' => ['Database Relasional', 'Manajemen Pesanan', 'Laporan Keuangan'],
                'gambar' => null,
            ],
            [
                'nama' => 'GARAP',
                'desk' => 'Console-based Python application providing agricultural land care services.',
                'desk_idn' => 'Aplikasi Python berbasis konsol yang menyediakan layanan perawatan lahan pertanian.',
                'full_desk' => 'GARAP is a console-based Python application providing agricultural land care services, allowing users to register land, select maintenance services, and simulate transaction records.',
                'full_desk_idn' => 'GARAP adalah aplikasi Python berbasis konsol yang menyediakan layanan perawatan lahan pertanian, memungkinkan pengguna mendaftarkan lahan, memilih layanan perawatan, dan menyimulasikan catatan transaksi.',
                'link' => 'https://github.com/Adya30/garap',
                'tools' => ['Python'],
                'fitur' => ['Land Registration', 'Maintenance Services', 'Transaction System'],
                'fitur_idn' => ['Registrasi Lahan', 'Layanan Perawatan', 'Sistem Transaksi'],
                'gambar' => null,
            ],
            [
                'nama' => 'SIPA',
                'desk' => 'Console-based Python application for agricultural land scheduling and management.',
                'desk_idn' => 'Aplikasi Python berbasis konsol untuk penjadwalan dan manajemen lahan pertanian.',
                'full_desk' => 'SIPA is a console-based Python information system for agricultural land scheduling, helping farmers organize planting, maintenance, and harvesting schedules in a structured way.',
                'full_desk_idn' => 'SIPA adalah sistem informasi Python berbasis konsol untuk penjadwalan lahan pertanian, membantu petani mengatur jadwal tanam, perawatan, dan panen secara terstruktur.',
                'link' => 'https://github.com/Adya30/SIPA',
                'tools' => ['Python'],
                'fitur' => ['Planting Schedule', 'Land Management', 'Activity History'],
                'fitur_idn' => ['Jadwal Penanaman', 'Manajemen Lahan', 'Riwayat Aktivitas'],
                'gambar' => null,
            ],
        ];

        foreach ($projects as $i => $project) {
            Project::updateOrCreate(
                ['nama' => $project['nama']],
                $project + [
                    'slug' => Str::slug($project['nama']),
                    'sort_order' => $i + 1,
                    'category_id' => $this->categoryByProject[$project['nama']] ?? null,
                ]
            );
        }
    }

    private function seedExperiences(): void
    {
        $experiences = [
            [
                'role' => 'External Relations Staff',
                'role_idn' => 'Staf Hubungan Eksternal',
                'company' => 'BEM FASILKOM UNEJ',
                'duration' => 'Dec 2025 - Present',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'Joined as a member of the External Affairs Division (External Subdivision) in the Student Executive Board (BEM). Focused on managing external relations, inter-organizational collaboration, and building strategic communication with both internal and external campus stakeholders. Actively contributed to strengthening the organization\u2019s public image, expanding student networks, and supporting the development of sustainable partnerships to enhance the implementation of BEM FASILKOM UNEJ programs.',
                'desk_idn' => 'Bergabung sebagai anggota Divisi Hubungan Luar (Subdivisi Eksternal) di Badan Eksekutif Mahasiswa (BEM). Fokus pada pengelolaan hubungan eksternal, kolaborasi antar organisasi, dan membangun komunikasi strategis dengan pemangku kepentingan kampus, baik internal maupun eksternal. Aktif berkontribusi memperkuat citra publik organisasi, memperluas jejaring mahasiswa, dan mendukung pengembangan kemitraan berkelanjutan untuk meningkatkan pelaksanaan program BEM FASILKOM UNEJ.',
                'skills' => ['Public Relations', 'Teamwork', 'Strategic Communication', 'Collaboration'],
            ],
            [
                'role' => 'Laboratory Teaching Assistant',
                'role_idn' => 'Asisten Praktikum Laboratorium',
                'company' => 'Software Engineering Laboratory (Ryper Lab)',
                'duration' => 'May 2025 - Present',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'Ryper Lab is a research laboratory under the Faculty of Computer Science, University of Jember, focusing on the analysis, design, development, and implementation of software solutions. The laboratory supports innovation and technology-driven research to deliver efficient and sustainable software products.',
                'desk_idn' => 'Ryper Lab adalah laboratorium riset di bawah Fakultas Ilmu Komputer Universitas Jember yang berfokus pada analisis, perancangan, pengembangan, dan implementasi solusi perangkat lunak. Laboratorium ini mendukung inovasi dan riset berbasis teknologi untuk menghasilkan produk perangkat lunak yang efisien dan berkelanjutan.',
                'practicum_desc' => 'I am involved as a Teaching Assistant (Practicum) under Ryper Lab, responsible for supporting practicum sessions for courses managed by the lab, specifically Algorithms & Programming and Database Systems. In this role, I guide students during practicum sessions, explain core concepts related to algorithms, programming logic, and database concepts, assist with programming exercises and database implementation, and ensure that all practicum activities run effectively in accordance with the curriculum.',
                'practicum_desc_idn' => 'Saya terlibat sebagai Asisten Praktikum di bawah Ryper Lab, bertanggung jawab mendukung sesi praktikum untuk mata kuliah yang dikelola laboratorium, khususnya Algoritma & Pemrograman dan Sistem Basis Data. Dalam peran ini, saya membimbing mahasiswa selama sesi praktikum, menjelaskan konsep inti terkait algoritma, logika pemrograman, dan konsep basis data, membantu latihan pemrograman dan implementasi basis data, serta memastikan seluruh aktivitas praktikum berjalan efektif sesuai kurikulum.',
                'skills' => ['Python', 'Algorithms & Programming', 'Database Systems', 'Leadership', 'Mentoring'],
            ],
            [
                'role' => 'Division Programming Staff',
                'role_idn' => 'Staf Divisi Programming',
                'company' => 'UKM Linux and Open Source (UKM LAOS)',
                'duration' => 'Dec 2024 - Dec 2025',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'As a member of the Programming Division at UKM LAOS, I actively contributed to learning and development activities focused on open-source technologies, software development, and collaborative programming. This role enhanced my technical skills, problem-solving abilities, and experience working in a collaborative, team-oriented environment.',
                'desk_idn' => 'Sebagai anggota Divisi Programming di UKM LAOS, saya aktif berkontribusi dalam kegiatan belajar dan pengembangan yang berfokus pada teknologi open source, pengembangan perangkat lunak, dan pemrograman kolaboratif. Peran ini meningkatkan keterampilan teknis, kemampuan pemecahan masalah, dan pengalaman bekerja dalam lingkungan kolaboratif berbasis tim.',
                'responsibilities' => [
                    'Participated in internal training sessions and workshops related to programming, open-source tools, and Linux-based development.',
                    'Collaborated with team members to develop small- to medium-scale projects applying open-source principles and clean coding practices.',
                    'Assisted in mentoring junior members by sharing knowledge on programming fundamentals and the use of open-source software.',
                    'Took part in technical discussions, code reviews, and problem-solving activities within the division.',
                    'Supported organizational activities such as coding classes, software installfests, and technical seminars.',
                ],
                'responsibilities_idn' => [
                    'Mengikuti pelatihan internal dan workshop terkait pemrograman, alat open source, dan pengembangan berbasis Linux.',
                    'Berkolaborasi dengan anggota tim untuk mengembangkan proyek skala kecil hingga menengah dengan menerapkan prinsip open source dan praktik kode yang bersih.',
                    'Membantu mentoring anggota junior dengan berbagi pengetahuan tentang dasar-dasar pemrograman dan penggunaan perangkat lunak open source.',
                    'Mengikuti diskusi teknis, peninjauan kode, dan kegiatan pemecahan masalah di dalam divisi.',
                    'Mendukung kegiatan organisasi seperti kelas coding, installfest perangkat lunak, dan seminar teknis.',
                ],
                'skills' => ['Python', 'JavaScript', 'Tailwind CSS', 'Bootstrap', 'React JS', 'Git & Version Control', 'Teamwork', 'Collaboration'],
            ],
            [
                'role' => 'Technical Staff',
                'role_idn' => 'Staf Teknis',
                'company' => 'SMAGI TV',
                'duration' => 'Jan 2022 - Jan 2023',
                'location' => 'SMAN 1 Giri, Banyuwangi',
                'desk' => 'As an IT Staff member at SMAGI TV, I supported the school\u2019s media and technology activities, particularly in digital content management and official website maintenance. Over the course of one year, I managed the content publication workflow and ensured that the website remained functional, up to date, and easily accessible.',
                'desk_idn' => 'Sebagai Staf IT di SMAGI TV, saya mendukung kegiatan media dan teknologi sekolah, khususnya dalam pengelolaan konten digital dan pemeliharaan website resmi. Selama satu tahun, saya mengelola alur publikasi konten dan memastikan website tetap fungsional, mutakhir, dan mudah diakses.',
                'responsibilities' => [
                    'Managed the uploading and publishing process of video content on the SMAGI TV channel, including quality checks, scheduling, and metadata optimization.',
                    'Performed website maintenance through regular content updates for the SMAGI TV website.',
                    'Handled and resolved technical issues related to content uploads and website functionality.',
                    'Collaborated with creative and multimedia teams in preparing and publishing content according to release standards.',
                    'Created documentation and helped streamline the content publication workflow.',
                ],
                'responsibilities_idn' => [
                    'Mengelola proses unggah dan publikasi konten video di kanal SMAGI TV, termasuk pengecekan kualitas, penjadwalan, dan optimasi metadata.',
                    'Melakukan pemeliharaan website melalui pembaruan konten rutin untuk website SMAGI TV.',
                    'Menangani dan menyelesaikan masalah teknis terkait unggahan konten dan fungsionalitas website.',
                    'Berkolaborasi dengan tim kreatif dan multimedia dalam menyiapkan serta memublikasikan konten sesuai standar rilis.',
                    'Membuat dokumentasi dan membantu merapikan alur publikasi konten.',
                ],
                'skills' => ['Communication', 'Web Development', 'Website Maintenance', 'Digital Content Management', 'Troubleshooting'],
            ],
        ];

        foreach ($experiences as $i => $experience) {
            Experience::updateOrCreate(
                ['role' => $experience['role']],
                $experience + [
                    'slug' => Str::slug($experience['role'] . ' ' . $experience['company']),
                    'sort_order' => $i + 1,
                ]
            );
        }
    }

    private function seedCertificates(): void
    {
        $certificates = [
            ['C# Basic Certificate', 'Sertifikat Dasar C#', 'HackerRank', 'December 24, 2025', null, 'Competency certification in basic C# programming covering control structures, basic object-oriented programming, exception handling, and collections.', 'Sertifikasi kompetensi pemrograman dasar C# yang mencakup struktur kendali, pemrograman berorientasi objek dasar, penanganan pengecualian, dan koleksi.'],
            ['Object-Oriented Programming (OOP)', 'Pemrograman Berorientasi Objek (OOP)', 'dicoding', 'December 17, 2025', null, 'Certification of understanding in object-oriented programming paradigm covering Encapsulation, Inheritance, Polymorphism, and Abstraction.', 'Sertifikasi pemahaman paradigma pemrograman berorientasi objek yang mencakup Enkapsulasi, Pewarisan, Polimorfisme, dan Abstraksi.'],
            ['C Programming', 'Pemrograman C', 'Dicoding', 'December 14, 2025', null, 'Fundamental understanding of procedural programming with C language, memory management, pointers, array manipulation, and basic data structures.', 'Pemahaman fundamental pemrograman prosedural dengan bahasa C, manajemen memori, pointer, manipulasi array, dan struktur data dasar.'],
            ['Junior Web Developer Certification', 'Sertifikasi Junior Web Developer', 'PT. Inixindo', 'November 05 - 08, 2025', null, 'Official national competency certification as a Junior Web Developer, validating skills in HTML, CSS, JavaScript, relational databases, and static/dynamic web implementations.', 'Sertifikasi kompetensi nasional resmi sebagai Junior Web Developer, memvalidasi keterampilan HTML, CSS, JavaScript, database relasional, dan implementasi web statis/dinamis.'],
            ['2nd Place in Game Development Competition', 'Juara 2 Lomba Pengembangan Game', 'HMIF', 'October 19, 2025', null, 'Award for achieving second place in a national creative game development competition, focusing on game mechanics design, asset integration, and gameplay.', 'Penghargaan meraih juara kedua dalam lomba pengembangan game kreatif tingkat nasional, berfokus pada desain mekanik game, integrasi aset, dan gameplay.'],
            ['Programming Division Member', 'Anggota Divisi Programming', 'UKM LAOS', 'December 1, 2025', null, 'Certification of leadership and dedication as a programming staff member in the information technology community, mentoring members in understanding basic programming algorithms.', 'Sertifikasi kepemimpinan dan dedikasi sebagai staf programming di komunitas teknologi informasi, mendampingi anggota dalam memahami algoritma pemrograman dasar.'],
            ['IT Staff SMAGITV', 'Staf IT SMAGITV', 'SMAN 1 Giri', 'October 13, 2023', null, 'Award for active contribution as information technology staff and school digital media broadcast management, designing local network infrastructure and live streaming portals.', 'Penghargaan atas kontribusi aktif sebagai staf teknologi informasi dan pengelola siaran media digital sekolah, merancang infrastruktur jaringan lokal dan portal live streaming.'],
            ['Gold Medal in Physics Olympiad', 'Medali Emas Olimpiade Fisika', 'OPN', 'October 30, 2022', null, 'Gold medal award in a national level academic competition in the field of Physics, validating logical analysis and complex problem-solving abilities.', 'Medali emas dalam kompetisi akademik tingkat nasional bidang Fisika, memvalidasi kemampuan analisis logis dan pemecahan masalah kompleks.'],
            ['Bronze Medal in Informatics Olympiad', 'Medali Perunggu Olimpiade Informatika', 'OPN', 'October 30, 2022', null, 'Bronze medal award in a national level Informatics competition, testing algorithm skills, data structures, and competitive programming problem-solving.', 'Medali perunggu dalam kompetisi Informatika tingkat nasional, menguji keterampilan algoritma, struktur data, dan pemecahan masalah pemrograman kompetitif.'],
            ['SEO & Content Marketing', 'SEO & Content Marketing', 'MySkill', 'January 13, 2025', null, 'Certification in Search Engine Optimization (SEO) strategies covering keyword research, on-page optimization, technical SEO, and performance measurement to improve website visibility and organic search rankings.', 'Sertifikasi strategi Search Engine Optimization (SEO) yang mencakup riset kata kunci, optimasi on-page, SEO teknis, dan pengukuran kinerja untuk meningkatkan visibilitas website dan peringkat pencarian organik.'],
            ['Getting Prospective Clients', 'Mendapatkan Calon Klien', 'MySkill', 'January 16, 2025', null, 'Certification in digital marketing client acquisition strategies, covering lead generation, conversion optimization, market analysis, and client relationship management for effective business growth.', 'Sertifikasi strategi akuisisi klien pemasaran digital, mencakup pembuatan prospek (lead generation), optimasi konversi, analisis pasar, dan manajemen hubungan klien untuk pertumbuhan bisnis yang efektif.'],
        ];

        foreach ($certificates as $i => [$nama, $nama_idn, $penerbit, $tanggal, $gambar, $desk, $desk_idn]) {
            Certificate::updateOrCreate(
                ['nama' => $nama],
                [
                    'slug' => Str::slug($nama),
                    'nama_idn' => $nama_idn,
                    'penerbit' => $penerbit,
                    'tanggal' => $tanggal,
                    'gambar' => $gambar,
                    'desk' => $desk,
                    'desk_idn' => $desk_idn,
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
