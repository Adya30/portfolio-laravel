<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Database\Seeder;

class PortfolioDataSeeder extends Seeder
{
    /**
     * Seed the portfolio content (projects, tools, certificates, experiences, profile).
     */
    public function run(): void
    {
        $this->seedProfile();
        $this->seedTools();
        $this->seedProjects();
        $this->seedExperiences();
        $this->seedCertificates();
    }

    private function seedProfile(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Adya Handika Putra AP',
                'role_title' => 'Web Developer | UI Design',
                'tagline' => 'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.',
                'about_1' => "Hello! I'm Adya Handika Putra AP, a Full Stack Developer with a deep passion for technology, open source, and exploring new programming concepts to build digital solutions that are both functional and precisely crafted.",
                'about_2' => "Currently pursuing a degree in Information Systems at the University of Jember, I'm constantly driven to learn, create, and contribute to the developer community through clean code, thoughtful architecture, and collaborative projects.",
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
            ['Visual Studio Code', 'Code Editor', null],
            ['HTML 5', 'Structure', null],
            ['CSS 3', 'Style', null],
            ['Javascript', 'Language', null],
            ['Tailwind CSS', 'Framework', null],
            ['Bootstrap', 'Framework', null],
            ['Postgre SQL', 'Database', null],
            ['Python', 'Language', null],
            ['React JS', 'Framework', null],
            ['Github', 'Repository', null],
            ['Canva', 'Design Tool', null],
            ['Figma', 'Design Tool', null],
            ['C#', 'Language', null],
            ['Laravel', 'Framework', null],
            ['MySQL', 'Database', null],
            ['PHP', 'Language', null],
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
                'full_desk' => 'AGRIS is a modern agroindustrial e-commerce and partnership platform connecting agricultural producers with distribution partners (agents). Built with Laravel 13 and Tailwind CSS v4, it integrates Midtrans, Biteship, Wilayah.id, and Google OAuth to deliver a secure, automated, and real-time shopping, logistics, and digital payment experience.',
                'link' => 'https://github.com/Adya30/Agris',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Admin & Agent Partnerships', 'Midtrans Payment Gateway', 'Biteship Logistics Integration', 'Google OAuth & OTP Verification', 'Wilayah.id Administrative Subdivisions'],
                'gambar' => null,
            ],
            [
                'nama' => 'Handman',
                'desk' => 'Office task management and collaboration platform with real-time tracking and scheduling.',
                'full_desk' => 'HANDMAN is an office task management and company internal collaboration platform designed to improve team workflow efficiency. Featuring Admin, Manager, and Staff roles, the app supports real-time task delegation, operational issue ticketing, interactive work agendas, and dynamic PDF report exports with filters.',
                'link' => 'https://github.com/Adya30/HANDMAN',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Real-Time Task Delegation', 'Work Agenda Calendar', 'Issue Ticketing System', 'Filtered PDF Report Export', 'Role-Based Access Control'],
                'gambar' => null,
            ],
            [
                'nama' => 'Kasirku',
                'desk' => 'Web-based cashier/POS (Point of Sale) system for managing sales transactions and inventory.',
                'full_desk' => 'Kasirku is a web-based cashier and Point of Sale (POS) system built using Laravel, PHP, and MySQL. It helps small businesses manage sales transactions, track product inventory, and generate digital transaction records in real-time.',
                'link' => 'https://github.com/Adya30/Kasirku',
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'NodeJs'],
                'fitur' => ['Point of Sale (POS)', 'Inventory Management', 'Transaction History', 'Real-Time Calculation'],
                'gambar' => null,
            ],
            [
                'nama' => 'Tanamin',
                'desk' => 'Agriculture and plant growth monitoring platform developed with C#, .NET, and PostgreSQL.',
                'full_desk' => 'Tanamin is a plant growth monitoring and agricultural management platform built using C#, .NET, and PostgreSQL. It helps users track planting schedules, monitor growth progress, and manage crop health.',
                'link' => 'https://github.com/Adya30/Project-Tanamin',
                'tools' => ['C#', 'PostgreSQL', '.Net'],
                'fitur' => ['Plant Growth Tracker', 'Planting Schedule', 'Database Integration', 'Health Monitoring'],
                'gambar' => null,
            ],
            [
                'nama' => 'Iphone UI',
                'desk' => 'Website UI slicing replica of Apple iPhone official website using vanilla CSS and JavaScript.',
                'full_desk' => 'A frontend UI slicing project of the Apple iPhone official website. Built using clean HTML, external CSS, and vanilla JS with a mobile-first responsive design, flexbox/grid layout, and Animate On Scroll (AOS) libraries.',
                'link' => 'https://github.com/Adya30/Iphone-UI',
                'tools' => ['HTML', 'CSS', 'JavaScript', 'Aos'],
                'fitur' => ['Mobile-First Responsive', 'Navbar Toggle DOM', 'Flexbox & Grid Layout', 'AOS Scroll Animation'],
                'gambar' => null,
            ],
            [
                'nama' => 'Fire Force',
                'desk' => 'A responsive anime landing page or character gallery built with HTML, CSS, JavaScript, and Bootstrap.',
                'full_desk' => 'Fire Force is a frontend landing page dedicated to the Fire Force anime series. Developed using HTML, CSS, JavaScript, and Bootstrap, the project features a responsive character gallery, lore explanations, and interactive visual elements.',
                'link' => 'https://github.com/Adya30/Fire-Force',
                'tools' => ['HTML', 'CSS', 'Javascript', 'Bootstrap'],
                'fitur' => ['Responsive Layout', 'Character Gallery', 'Anime Information Hub', 'Interactive DOM Elements'],
                'gambar' => null,
            ],
            [
                'nama' => 'Gorengin Aja!',
                'desk' => 'Online fritter ordering platform for the Mastrip area built with basic web technologies.',
                'full_desk' => 'Gorengin Aja! is an online fritter ordering platform built for Mastrip area vendors. Developed using vanilla HTML, CSS, and JavaScript, the application allows customers to browse the menu and place orders digitally.',
                'link' => 'https://github.com/Adya30/gorengan_template',
                'tools' => ['HTML', 'CSS', 'Javascript'],
                'fitur' => ['Menu Catalog', 'Ordering System', 'Responsive Design'],
                'gambar' => null,
            ],
            [
                'nama' => 'SMAGITV Blog',
                'desk' => 'Online magazine and news blog for SMAN 1 Giri built on the Blogger platform.',
                'full_desk' => 'SMAGITV Blog is the online magazine and journal portal for SMAN 1 Giri. Built on the Blogger platform with custom HTML and CSS styling, it serves as a central news and activities portal for the school.',
                'link' => 'https://majalahonlinesman1giri.blogspot.com/',
                'tools' => ['HTML', 'CSS', 'Blogger'],
                'fitur' => ['School News', 'Activity Gallery', 'Educational Articles'],
                'gambar' => null,
            ],
            [
                'nama' => 'Adya Blog',
                'desk' => 'Personal blog containing professional ethics resumes and articles built with Blogger.',
                'full_desk' => 'Adya Blog is a personal blog containing resumes and articles about professional ethics in information technology. Built on the Blogger platform with layout customization.',
                'link' => 'https://adyahan1.blogspot.com',
                'tools' => ['HTML', 'CSS', 'Blogger'],
                'fitur' => ['Blog Articles', 'Post Categories', 'Responsive Layout'],
                'gambar' => null,
            ],
            [
                'nama' => 'SINABIL',
                'desk' => 'Database and relational tables design of the SINABIL Catering Information System.',
                'full_desk' => 'SINABIL is a database system for catering management. Developed using Python and PostgreSQL, it features relational database design with tables for orders, customers, menu, and financial reports.',
                'link' => 'https://docs.google.com/document/d/18WRWZXAJY-URu0uZjnjDEM4nNbl70Gbgjl6FYmt7pg0/edit?usp=sharing',
                'tools' => ['Python', 'PostgreSQL'],
                'fitur' => ['Relational Database', 'Order Management', 'Financial Reports'],
                'gambar' => null,
            ],
            [
                'nama' => 'GARAP',
                'desk' => 'Console-based Python application providing agricultural land care services.',
                'full_desk' => 'GARAP is a console-based Python application providing agricultural land care services, allowing users to register land, select maintenance services, and simulate transaction records.',
                'link' => 'https://github.com/Adya30/garap',
                'tools' => ['Python'],
                'fitur' => ['Land Registration', 'Maintenance Services', 'Transaction System'],
                'gambar' => null,
            ],
            [
                'nama' => 'SIPA',
                'desk' => 'Console-based Python application for agricultural land scheduling and management.',
                'full_desk' => 'SIPA is a console-based Python information system for agricultural land scheduling, helping farmers organize planting, maintenance, and harvesting schedules in a structured way.',
                'link' => 'https://github.com/Adya30/SIPA',
                'tools' => ['Python'],
                'fitur' => ['Planting Schedule', 'Land Management', 'Activity History'],
                'gambar' => null,
            ],
        ];

        foreach ($projects as $i => $project) {
            Project::updateOrCreate(
                ['nama' => $project['nama']],
                $project + ['sort_order' => $i + 1]
            );
        }
    }

    private function seedExperiences(): void
    {
        $experiences = [
            [
                'role' => 'External Relations Staff',
                'company' => 'BEM FASILKOM UNEJ',
                'duration' => 'Dec 2025 - Present',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'Joined as a member of the External Affairs Division (External Subdivision) in the Student Executive Board (BEM). Focused on managing external relations, inter-organizational collaboration, and building strategic communication with both internal and external campus stakeholders. Actively contributed to strengthening the organization\u2019s public image, expanding student networks, and supporting the development of sustainable partnerships to enhance the implementation of BEM FASILKOM UNEJ programs.',
                'skills' => ['Public Relations', 'Teamwork', 'Strategic Communication', 'Collaboration'],
            ],
            [
                'role' => 'Laboratory Teaching Assistant',
                'company' => 'Software Engineering Laboratory (Ryper Lab)',
                'duration' => 'May 2025 - Present',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'Ryper Lab is a research laboratory under the Faculty of Computer Science, University of Jember, focusing on the analysis, design, development, and implementation of software solutions. The laboratory supports innovation and technology-driven research to deliver efficient and sustainable software products.',
                'practicum_desc' => 'I am involved as a Teaching Assistant (Practicum) under Ryper Lab, responsible for supporting practicum sessions for courses managed by the lab, specifically Algorithms & Programming and Database Systems. In this role, I guide students during practicum sessions, explain core concepts related to algorithms, programming logic, and database concepts, assist with programming exercises and database implementation, and ensure that all practicum activities run effectively in accordance with the curriculum.',
                'skills' => ['Python', 'Algorithms & Programming', 'Database Systems', 'Leadership', 'Mentoring'],
            ],
            [
                'role' => 'Division Programming Staff',
                'company' => 'UKM Linux and Open Source (UKM LAOS)',
                'duration' => 'Dec 2024 - Dec 2025',
                'location' => 'Faculty of Computer Science, University of Jember',
                'desk' => 'As a member of the Programming Division at UKM LAOS, I actively contributed to learning and development activities focused on open-source technologies, software development, and collaborative programming. This role enhanced my technical skills, problem-solving abilities, and experience working in a collaborative, team-oriented environment.',
                'responsibilities' => [
                    'Participated in internal training sessions and workshops related to programming, open-source tools, and Linux-based development.',
                    'Collaborated with team members to develop small- to medium-scale projects applying open-source principles and clean coding practices.',
                    'Assisted in mentoring junior members by sharing knowledge on programming fundamentals and the use of open-source software.',
                    'Took part in technical discussions, code reviews, and problem-solving activities within the division.',
                    'Supported organizational activities such as coding classes, software installfests, and technical seminars.',
                ],
                'skills' => ['Python', 'JavaScript', 'Tailwind CSS', 'Bootstrap', 'React JS', 'Git & Version Control', 'Teamwork', 'Collaboration'],
            ],
            [
                'role' => 'Technical Staff',
                'company' => 'SMAGI TV',
                'duration' => 'Jan 2022 - Jan 2023',
                'location' => 'SMAN 1 Giri, Banyuwangi',
                'desk' => 'As an IT Staff member at SMAGI TV, I supported the school\u2019s media and technology activities, particularly in digital content management and official website maintenance. Over the course of one year, I managed the content publication workflow and ensured that the website remained functional, up to date, and easily accessible.',
                'responsibilities' => [
                    'Managed the uploading and publishing process of video content on the SMAGI TV channel, including quality checks, scheduling, and metadata optimization.',
                    'Performed website maintenance through regular content updates for the SMAGI TV website.',
                    'Handled and resolved technical issues related to content uploads and website functionality.',
                    'Collaborated with creative and multimedia teams in preparing and publishing content according to release standards.',
                    'Created documentation and helped streamline the content publication workflow.',
                ],
                'skills' => ['Communication', 'Web Development', 'Website Maintenance', 'Digital Content Management', 'Troubleshooting'],
            ],
        ];

        foreach ($experiences as $i => $experience) {
            Experience::updateOrCreate(
                ['role' => $experience['role']],
                $experience + ['sort_order' => $i + 1]
            );
        }
    }

    private function seedCertificates(): void
    {
        $certificates = [
            ['C# Basic Certificate', 'HackerRank', 'December 24, 2025', null, 'ri-code-line', 'Competency certification in basic C# programming covering control structures, basic object-oriented programming, exception handling, and collections.'],
            ['Object-Oriented Programming (OOP)', 'dicoding', 'December 17, 2025', null, 'ri-instance-line', 'Certification of understanding in object-oriented programming paradigm covering Encapsulation, Inheritance, Polymorphism, and Abstraction.'],
            ['C Programming', 'Dicoding', 'December 14, 2025', null, 'ri-code-box-line', 'Fundamental understanding of procedural programming with C language, memory management, pointers, array manipulation, and basic data structures.'],
            ['Junior Web Developer Certification', 'PT. Inixindo', 'November 05 - 08, 2025', null, 'ri-global-line', 'Official national competency certification as a Junior Web Developer, validating skills in HTML, CSS, JavaScript, relational databases, and static/dynamic web implementations.'],
            ['2nd Place in Game Development Competition', 'HMIF', 'October 19, 2025', null, 'ri-gamepad-fill', 'Award for achieving second place in a national creative game development competition, focusing on game mechanics design, asset integration, and gameplay.'],
            ['Programming Division Member', 'UKM LAOS', 'December 1, 2025', null, 'ri-team-line', 'Certification of leadership and dedication as a programming staff member in the information technology community, mentoring members in understanding basic programming algorithms.'],
            ['IT Staff SMAGITV', 'SMAN 1 Giri', 'October 13, 2023', null, 'ri-tv-line', 'Award for active contribution as information technology staff and school digital media broadcast management, designing local network infrastructure and live streaming portals.'],
            ['Gold Medal in Physics Olympiad', 'OPN', 'October 30, 2022', null, 'ri-award-fill', 'Gold medal award in a national level academic competition in the field of Physics, validating logical analysis and complex problem-solving abilities.'],
            ['Bronze Medal in Informatics Olympiad', 'OPN', 'October 30, 2022', null, 'ri-award-line', 'Bronze medal award in a national level Informatics competition, testing algorithm skills, data structures, and competitive programming problem-solving.'],
            ['SEO & Content Marketing', 'MySkill', 'January 13, 2025', null, 'ri-line-chart-line', 'Certification in Search Engine Optimization (SEO) strategies covering keyword research, on-page optimization, technical SEO, and performance measurement to improve website visibility and organic search rankings.'],
            ['Getting Prospective Clients', 'MySkill', 'January 16, 2025', null, 'ri-handshake-line', 'Certification in digital marketing client acquisition strategies, covering lead generation, conversion optimization, market analysis, and client relationship management for effective business growth.'],
        ];

        foreach ($certificates as $i => [$nama, $penerbit, $tanggal, $gambar, $icon, $desk]) {
            Certificate::updateOrCreate(
                ['nama' => $nama],
                [
                    'penerbit' => $penerbit,
                    'tanggal' => $tanggal,
                    'gambar' => $gambar,
                    'icon' => $icon,
                    'desk' => $desk,
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
