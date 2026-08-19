import 'remixicon/fonts/remixicon.css';
import 'animate.css/animate.min.css';
import 'aos/dist/aos.css';
// highlight.js — only the languages used by the course code blocks, to keep
// the bundle small (registering the full package would add ~900 kB).
import hljs from 'highlight.js/lib/core';
import 'highlight.js/styles/atom-one-dark.min.css';
import php from 'highlight.js/lib/languages/php';
import javascript from 'highlight.js/lib/languages/javascript';
import typescript from 'highlight.js/lib/languages/typescript';
import xml from 'highlight.js/lib/languages/xml';
import css from 'highlight.js/lib/languages/css';
import sql from 'highlight.js/lib/languages/sql';
import python from 'highlight.js/lib/languages/python';
import bash from 'highlight.js/lib/languages/bash';
import json from 'highlight.js/lib/languages/json';
import csharp from 'highlight.js/lib/languages/csharp';
import java from 'highlight.js/lib/languages/java';
import plaintext from 'highlight.js/lib/languages/plaintext';

hljs.registerLanguage('php', php);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('typescript', typescript);
hljs.registerLanguage('html', xml);
hljs.registerLanguage('css', css);
hljs.registerLanguage('sql', sql);
hljs.registerLanguage('python', python);
hljs.registerLanguage('bash', bash);
hljs.registerLanguage('json', json);
hljs.registerLanguage('csharp', csharp);
hljs.registerLanguage('java', java);
hljs.registerLanguage('plaintext', plaintext);
import AOS from 'aos';
import Alpine from 'alpinejs';
import './image-uploader';

window.Alpine = Alpine;

/* ============================================================
   CONTENT DATA — loaded from the server (window.portfolioData,
   rendered by the landing route from the database).
   ============================================================ */

const serverData = window.portfolioData || {};

const tools = serverData.tools || [];
const projects = serverData.projects || [];
const experiences = serverData.experiences || [];
const certificates = serverData.certificates || [];

/* ============================================================
   I18N — UI string dictionary for the language toggle (EN/ID).
   The active language is stored in localStorage under 'lang'.
   ============================================================ */
const i18n = {
    en: {
        navHome: 'Home',
        navAbout: 'About',
        navSkills: 'Skills',
        navProjects: 'Projects',
        navExperiences: 'Experiences',
        navCertificates: 'Certificates',
        navCourse: 'Course',
        navContact: 'Contact',
        downloadCv: 'Download CV',
        viewProjects: 'View Projects',
        certificates: 'Certificates',
        projects: 'Projects',
        aboutMe: 'About Me',
        aboutSubtitle: 'A brief story about my journey in tech and what drives me',
        projectsCompleted: 'Projects Completed',
        certifications: 'Certifications',
        toolsMastered: 'Tools Mastered',
        toolsSkills: 'Tools & Skills',
        toolsSkillsSubtitle: 'Any tools and skills I use regularly',
        recentProjects: 'Recent Projects',
        projectsSubtitle: 'Click on any project to see full details',
        all: 'All',
        view: 'View',
        project: 'Project',
        myExperience: 'My Experience',
        experiencesSubtitle: 'Click on any experience to see the full details',
        practicumResponsibilities: 'Practicum Responsibilities',
        keyResponsibilities: 'Key Responsibilities',
        skillsLabel: 'Skills:',
        viewDetails: 'View Details',
        certificatesAwards: 'Certificates & Awards',
        certificatesSubtitle: 'Click on any certificate to see full details',
        letsTalk: "Let's Talk",
        contactSubtitle: 'Have a project in mind or just want to say hi? Feel free to reach out directly!',
        contactBody: 'I am always open to discussing new projects, collaboration opportunities, or just to say hi. Send your email and I will respond as soon as possible!',
        quickLinks: 'Quick Links',
        connect: 'Connect',
        home: 'Home',
        backToProjects: 'Back to Projects',
        aboutThisProject: 'About This Project',
        keyFeatures: 'Key Features',
        toolsSkillsUsed: 'Tools & Skills Used',
        sourceCode: 'Source Code',
        visitWebsite: 'Visit Website',
        projectInfo: 'Project Info',
        projectNumber: 'Project Number',
        toolsUsed: 'Tools Used',
        noToolsYet: 'No tools are listed for this project yet.',
        previousProject: 'Previous Project',
        nextProject: 'Next Project',
        overview: 'Overview',
        backToExperiences: 'Back to Experiences',
        skillsUsed: 'Skills Used',
        noSkillsYet: 'No skills are listed for this experience yet.',
        atAGlance: 'At a Glance',
        company: 'Company',
        duration: 'Duration',
        location: 'Location',
        previous: 'Previous',
        next: 'Next',
        backToCertificates: 'Back to Certificates',
        aboutThisCertificate: 'About This Certificate',
        certificateDetails: 'Certificate Details',
        issuer: 'Issuer',
        issued: 'Issued',
        type: 'Type',
        certificate: 'Certificate',
        visitPlatform: 'Visit Platform',
        experience: 'Experience',
        projectsBreadcrumb: 'Projects',
        experiencesBreadcrumb: 'Experiences',
        certificatesBreadcrumb: 'Certificates',
        toggleLanguage: 'Switch language',
        course: 'Course',
        courseTitle: 'Course Programming',
        courseSubtitle: 'Welcome To Programming Course',
        material: 'Material',
        noCoursesYet: 'No materials have been added yet.',
        backToHome: 'Back to Home',
        backToOverview: 'Back to Overview',
        chapter: 'Chapter',
        of: 'of',
        previousChapter: 'Previous Chapter',
        nextChapter: 'Next Chapter',
        copy: 'Copy',
        copied: 'Copied!',
        toggleSidebar: 'Toggle sidebar',
        onThisPage: 'Sub Heading',
        subchapters: 'Subbab',
        tableOfContents: 'Daftar Subbab',
        subchapter: 'Subbab',
        previousSubchapter: 'Previous Subchapter',
        nextSubchapter: 'Next Subchapter',
    },
    id: {
        navHome: 'Beranda',
        navAbout: 'Tentang',
        navSkills: 'Keahlian',
        navProjects: 'Proyek',
        navExperiences: 'Pengalaman',
        navCertificates: 'Sertifikat',
        navCourse: 'Kursus',
        navContact: 'Kontak',
        downloadCv: 'Unduh CV',
        viewProjects: 'Lihat Proyek',
        certificates: 'Sertifikat',
        projects: 'Proyek',
        aboutMe: 'Tentang Saya',
        aboutSubtitle: 'Kisah singkat tentang perjalanan saya di dunia teknologi dan apa yang memotivasi saya',
        projectsCompleted: 'Proyek Selesai',
        certifications: 'Sertifikasi',
        toolsMastered: 'Tools Dikuasai',
        toolsSkills: 'Tools & Keahlian',
        toolsSkillsSubtitle: 'Berbagai tools dan keahlian yang saya gunakan secara rutin',
        recentProjects: 'Proyek Terbaru',
        projectsSubtitle: 'Berbagai Projek yang telah saya kerjakan',
        all: 'Semua',
        view: 'Lihat',
        project: 'Proyek',
        myExperience: 'Pengalaman Saya',
        experiencesSubtitle: 'Pengalaman yang telah saya tempuh dan masih saya tempuh',
        practicumResponsibilities: 'Tanggung Jawab Praktikum',
        keyResponsibilities: 'Tanggung Jawab Utama',
        skillsLabel: 'Keahlian:',
        viewDetails: 'Lihat Detail',
        certificatesAwards: 'Sertifikat & Penghargaan',
        certificatesSubtitle: 'Sertifikat dan penghargaan yang saya raih',
        letsTalk: 'Mari Berbicara',
        contactSubtitle: 'Punya proyek atau sekadar ingin menyapa? Jangan ragu untuk menghubungi saya!',
        contactBody: 'Saya selalu terbuka untuk berdiskusi soal proyek baru, peluang kolaborasi, atau sekadar menyapa. Kirim email Anda dan saya akan segera membalas!',
        quickLinks: 'Tautan Cepat',
        connect: 'Terhubung',
        home: 'Beranda',
        backToProjects: 'Kembali ke Proyek',
        aboutThisProject: 'Tentang Proyek Ini',
        keyFeatures: 'Fitur Utama',
        toolsSkillsUsed: 'Tools & Keahlian yang Digunakan',
        sourceCode: 'Kode Sumber',
        visitWebsite: 'Kunjungi Website',
        projectInfo: 'Info Proyek',
        projectNumber: 'Nomor Proyek',
        toolsUsed: 'Tools Digunakan',
        noToolsYet: 'Belum ada tools yang terdaftar untuk proyek ini.',
        previousProject: 'Proyek Sebelumnya',
        nextProject: 'Proyek Berikutnya',
        overview: 'Gambaran Umum',
        backToExperiences: 'Kembali ke Pengalaman',
        skillsUsed: 'Keahlian yang Digunakan',
        noSkillsYet: 'Belum ada keahlian yang terdaftar untuk pengalaman ini.',
        atAGlance: 'Sekilas Info',
        company: 'Perusahaan',
        duration: 'Periode',
        location: 'Lokasi',
        previous: 'Sebelumnya',
        next: 'Berikutnya',
        backToCertificates: 'Kembali ke Sertifikat',
        aboutThisCertificate: 'Tentang Sertifikat Ini',
        certificateDetails: 'Detail Sertifikat',
        issuer: 'Penerbit',
        issued: 'Diterbitkan',
        type: 'Jenis',
        certificate: 'Sertifikat',
        visitPlatform: 'Kunjungi Platform',
        experience: 'Pengalaman',
        projectsBreadcrumb: 'Proyek',
        experiencesBreadcrumb: 'Pengalaman',
        certificatesBreadcrumb: 'Sertifikat',
        toggleLanguage: 'Ganti bahasa',
        course: 'Kursus',
        courseTitle: 'Materi Pembelajaran',
        courseSubtitle: 'Kumpulan materi belajar untuk mengasah keahlianmu di bidang pengembangan web, pemrograman, dan desain UI.',
        material: 'Materi',
        noCoursesYet: 'Belum ada materi yang ditambahkan.',
        backToHome: 'Kembali ke Beranda',
        backToOverview: 'Kembali ke Daftar Materi',
        chapter: 'Bab',
        of: 'dari',
        previousChapter: 'Bab Sebelumnya',
        nextChapter: 'Bab Berikutnya',
        copy: 'Salin',
        copied: 'Tersalin!',
        toggleSidebar: 'Buka/Tutup sidebar',
        onThisPage: 'Di Halaman Ini',
        subchapters: 'Subbab',
        tableOfContents: 'Daftar Subbab',
        subchapter: 'Subbab',
        previousSubchapter: 'Subbab Sebelumnya',
        nextSubchapter: 'Subbab Berikutnya',
    },
};

/* ============================================================
   LANGUAGE STORE — the current language lives in a reactive
   Alpine store so that t()/L() reads (which go through the
   store proxy) are tracked by Alpine effects and re-run when
   the language changes.
   ============================================================ */
Alpine.store('lang', {
    current: (() => {
        try {
            return document.documentElement.dataset.lang || localStorage.getItem('lang') || 'en';
        } catch (e) {
            return 'en';
        }
    })(),
    set(lang) {
        this.current = lang;
        try {
            localStorage.setItem('lang', lang);
            document.documentElement.lang = lang;
            document.documentElement.dataset.lang = lang;
        } catch (e) {}
    },
});

/* ============================================================
   ROOT APP COMPONENT
   ============================================================ */
Alpine.data('app', () => ({
    dark: false,
    scrolled: false,

    // Course detail sidebar: hidden by default on mobile (slide-in drawer),
    // open by default on desktop, where the collapsed state is persisted.
    sidebarOpen: (() => {
        try {
            return window.matchMedia('(min-width: 1024px)').matches
                ? localStorage.getItem('courseSidebar') !== 'closed'
                : false;
        } catch (e) {
            return false;
        }
    })(),
    active: 'beranda',
    tools,
    projects,
    experiences,
    certificates,

    init() {
        const stored = localStorage.getItem('theme');
        this.dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', this.dark);

        // Landing page: when the page is refreshed, always go back to the
        // top (beranda) — never restore the previous scroll position, and
        // clear any URL hash (e.g. /#proyek) so the active nav resets too.
        // Arriving from a detail-page navbar click (a fresh navigation with
        // a hash) still scrolls to the target section below.
        if (window.portfolioData) {
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            if (this.isReload()) {
                if (window.location.hash) {
                    history.replaceState(null, '', window.location.pathname + window.location.search);
                }
                window.scrollTo(0, 0);
            }
        }

        // Initial active nav item: on detail pages the server provides the
        // matching section via data-active-nav (e.g. 'proyek' on /project/1);
        // on the landing page a URL hash (e.g. /#proyek) wins.
        this.active = document.body.dataset.activeNav || 'beranda';
        if (window.location.hash && document.querySelector(window.location.hash)) {
            this.active = window.location.hash.slice(1);
        }

        // Navbar shrink on scroll (set once on init so a page reload while
        // scrolled down renders the correct state immediately)
        this.scrolled = window.scrollY > 40;
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 40;
        }, { passive: true });

        // Scroll-spy for the active section
        const sections = document.querySelectorAll('section[id]');
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) this.active = entry.target.id;
                });
            },
            { threshold: 0.15, rootMargin: '-80px 0px -40px 0px' }
        );
        sections.forEach((section) => observer.observe(section));

        // AOS animations
        AOS.init({ once: true, duration: 800, offset: 40 });

        // Browser back/forward support for SPA subbab navigation
        window.addEventListener('popstate', () => {
            if (window.location.pathname.includes('/course/') && window.location.pathname.includes('/subbab/')) {
                this.navigateSubbab(window.location.href);
            } else {
                window.location.reload();
            }
        });

        // Code block syntax highlighting via highlight.js
        this.$nextTick(() => {
            document.querySelectorAll('pre code').forEach((el) => {
                try {
                    hljs.highlightElement(el);
                } catch (e) {}
            });
        });

        // When arriving with a URL hash (e.g. /#proyek from a detail page
        // navbar click), scroll to that section once the page is ready.
        if (window.location.hash) {
            setTimeout(() => {
                const target = document.querySelector(window.location.hash);
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 200);
        }
    },

    isReload() {
        try {
            const entry = performance.getEntriesByType?.('navigation')?.[0];
            if (entry) return entry.type === 'reload';

            // Fallback for older browsers (legacy Navigation Timing API).
            return typeof performance.navigation !== 'undefined' && performance.navigation.type === 1;
        } catch (e) {
            return false;
        }
    },

    toggleTheme() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
    },

    // Open/close the course detail sidebar. On mobile it's a slide-in drawer;
    // on desktop the sidebar collapses to give the content full width.
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        try {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                localStorage.setItem('courseSidebar', this.sidebarOpen ? 'open' : 'closed');
            }
        } catch (e) {}
    },

    // AJAX navigation for subbab links — replaces only the main content
    // area and updates sidebar active states without a full page reload.
    // The sidebar DOM stays untouched so it never re-renders or animates.
    navigateSubbab(url, event) {
        if (event) event.preventDefault();
        if (this._navigating) return;
        this._navigating = true;

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');

                // 1. Replace main content only
                const newMain = doc.querySelector('main');
                const oldMain = document.querySelector('main');
                if (newMain && oldMain) {
                    oldMain.innerHTML = newMain.innerHTML;
                }

                // 2. Update sidebar active states by tweaking classes,
                //    NOT by replacing the sidebar innerHTML (keeps shape).
                const oldSidebar = document.querySelector('aside[x-cloak]');
                if (oldSidebar) {
                    const newSidebar = doc.querySelector('aside[x-cloak]');
                    if (newSidebar) {
                        // Update collapsed sidebar links
                        const oldCollapsedLinks = oldSidebar.querySelectorAll('.flex-col.items-center a[href*="/subbab/"]');
                        const newCollapsedLinks = newSidebar.querySelectorAll('.flex-col.items-center a[href*="/subbab/"]');
                        oldCollapsedLinks.forEach((link, i) => {
                            if (newCollapsedLinks[i]) {
                                link.className = newCollapsedLinks[i].className;
                            }
                        });

                        // Update expanded sidebar links
                        const oldExpandedLinks = oldSidebar.querySelectorAll('.overflow-y-auto a[href*="/subbab/"]');
                        const newExpandedLinks = newSidebar.querySelectorAll('.overflow-y-auto a[href*="/subbab/"]');
                        oldExpandedLinks.forEach((link, i) => {
                            if (newExpandedLinks[i]) {
                                link.className = newExpandedLinks[i].className;
                                // Also update inner span classes (number badge)
                                const oldSpan = link.querySelector('span');
                                const newSpan = newExpandedLinks[i].querySelector('span');
                                if (oldSpan && newSpan) oldSpan.className = newSpan.className;
                            }
                        });
                    }
                }

                // 3. Update TOC sidebar
                const newToc = doc.querySelector('aside[x-data="tocSpy"]');
                const oldToc = document.querySelector('aside[x-data="tocSpy"]');
                if (newToc && oldToc) {
                    oldToc.innerHTML = newToc.innerHTML;
                    oldToc.style.display = '';
                    // Re-observe headings so the active state tracks correctly
                    // after the innerHTML replacement.
                    const tocData = Alpine.$data(oldToc);
                    if (tocData && typeof tocData._observe === 'function') {
                        tocData._observe();
                    }
                } else if (oldToc && !newToc) {
                    oldToc.style.display = 'none';
                }

                // 4. Update URL without reload
                history.pushState({}, '', url);
                window.scrollTo(0, 0);

                // 5. Re-run AOS for new elements
                if (window.AOS) AOS.refresh();

                // 6. Re-highlight code blocks
                this.$nextTick(() => {
                    document.querySelectorAll('pre code').forEach(el => {
                        try { hljs.highlightElement(el); } catch (e) {}
                    });
                });

                this._navigating = false;
            })
            .catch(() => {
                window.location.href = url;
            });
    },

    /* --- Language helpers --- */
    t(key) {
        const lang = Alpine.store('lang').current;
        return (i18n[lang] && i18n[lang][key]) || i18n.en[key] || key;
    },

    // Pick the right content language for a record: pass the English value and
    // the optional Indonesian value. Falls back to English when Indonesian is
    // missing (or when the two arrays differ in length).
    L(en, idn) {
        const lang = Alpine.store('lang').current;
        if (lang === 'id') {
            if (Array.isArray(en)) {
                if (Array.isArray(idn) && idn.length === en.length) return idn;
                return en;
            }
            if (idn !== null && idn !== undefined && idn !== '') return idn;
        }
        return en ?? '';
    },

    scrollToSection(e, href) {
        if (e && e.preventDefault) e.preventDefault();
        if (!href || href === '#') return;
        try {
            const el = document.querySelector(href);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (window.landingUrl) {
                window.location.href = window.landingUrl + href;
            }
        } catch (err) {
            // Fallback for non-standard selector or missing element
        }
    },

    // Copy a code block's content to the clipboard (used by the course
    // detail page code blocks).
    // The button lives in the header bar, so we walk up to the outer
    // code-block wrapper (closest div with overflow-hidden) and then
    // find the <code> element inside it.
    async copyCode(button) {
        // Walk up to the outermost code-block container div, then find code inside.
        const wrapper = button.closest('div[class*="rounded-xl"]');
        const codeEl  = wrapper ? wrapper.querySelector('pre code') : null;
        const text    = codeEl ? (codeEl.innerText || codeEl.textContent || '') : '';

        if (text) {
            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(text);
                } else {
                    await this._fallbackCopy(text);
                }
            } catch {
                await this._fallbackCopy(text);
            }
        }

        const icon     = button.querySelector('i');
        const label    = button.querySelector('span');
        const original = label ? label.textContent : '';
        if (icon)  icon.className    = 'ri-check-line';
        if (label) label.textContent = this.t('copied') || 'Tersalin!';
        setTimeout(() => {
            if (icon)  icon.className    = 'ri-file-copy-line';
            if (label) label.textContent = original;
        }, 2000);
    },

    _fallbackCopy(text) {
        return new Promise((resolve) => {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.setAttribute('readonly', '');
            ta.style.cssText = 'position:fixed;top:0;left:0;width:1px;height:1px;padding:0;border:none;outline:none;box-shadow:none;background:transparent;';
            document.body.appendChild(ta);
            ta.focus({ preventScroll: true });
            ta.select();
            ta.setSelectionRange(0, ta.value.length);
            try {
                document.execCommand('copy');
            } catch (_) {}
            document.body.removeChild(ta);
            resolve();
        });
    },
}));

/* ============================================================
   COURSE CONTENT EDITOR — admin block builder for course
   materials (subbab, paragraf, gambar, kode). The block list is
   serialized to the hidden `konten` input as JSON on submit.
   ============================================================ */
Alpine.data('courseContentEditor', (initialBlocks = [], uploadUrl = '') => ({
    blocks: Array.isArray(initialBlocks) ? initialBlocks : [],
    uploadUrl,
    uploadingIndex: null,
    uploadError: '',
    draggedIndex: null,

    init() {
        // When arriving from the admin subbab list (edit#blok-{index}), scroll
        // to that block once the x-for items have been rendered.
        this.$nextTick(() => {
            const hash = window.location.hash;
            if (!hash) return;
            try {
                const el = this.$el.querySelector(hash);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (_) {}
        });
    },

    insertTab(e) {
        const textarea = e.target;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const value = textarea.value;
        textarea.value = value.substring(0, start) + "    " + value.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + 4;
        textarea.dispatchEvent(new Event('input'));
    },

    // Wrap the selected text of the paragraph with the clicked format. When
    // nothing is selected, append a placeholder marker (old behaviour).
    applyFormat(index, fmt, btnEl = null) {
        if (!this.blocks[index] || this.blocks[index].type !== 'paragraf') return;

        const textarea = btnEl ? btnEl.closest('.paragraf-block')?.querySelector('textarea') : null;
        let text = this.blocks[index].teks || '';
        const start = textarea ? textarea.selectionStart : null;
        const end = textarea ? textarea.selectionEnd : null;
        const hasSelection = start !== null && end !== null && end > start;

        if (hasSelection) {
            const selected = text.substring(start, end);
            let formatted = selected;

            if (fmt === 'bold') formatted = '**' + selected + '**';
            else if (fmt === 'italic') formatted = '*' + selected + '*';
            else if (fmt === 'underline') formatted = '<u>' + selected + '</u>';
            else if (fmt === 'quote') formatted = selected.split('\n').map((line) => '> ' + line).join('\n');
            else if (fmt === 'bullet') formatted = selected.split('\n').map((line) => '- ' + line).join('\n');
            else if (fmt === 'number') formatted = selected.split('\n').map((line, i) => (i + 1) + '. ' + line).join('\n');

            this.blocks[index].teks = text.substring(0, start) + formatted + text.substring(end);

            // Keep the formatted text highlighted so more formats can be stacked.
            this.$nextTick(() => {
                textarea.focus();
                textarea.setSelectionRange(start, start + formatted.length);
            });
            return;
        }

        if (fmt === 'bold') text += ' **teks tebal**';
        else if (fmt === 'italic') text += ' *teks miring*';
        else if (fmt === 'underline') text += ' <u>teks garis bawah</u>';
        else if (fmt === 'quote') text += '\n> Tulis kutipan di sini...';
        else if (fmt === 'bullet') text += '\n- Poin 1\n- Poin 2';
        else if (fmt === 'number') text += '\n1. Poin 1\n2. Poin 2';
        this.blocks[index].teks = text;
    },

    blockLabel(type) {
        return {
            subbab: 'Subbab',
            subheading: 'Sub Heading',
            paragraf: 'Paragraf',
            gambar: 'Gambar',
            kode: 'Kode',
            link: 'Sisipan Link',
            pembatas: 'Pembatas',
        }[type] || 'Blok';
    },

    addBlock(type) {
        const base = { type };
        if (type === 'subbab') {
            base.judul = '';
        } else if (type === 'subheading') {
            base.teks = '';
        } else if (type === 'paragraf') {
            base.teks = '';
            base.align = 'kiri';
        } else if (type === 'gambar') {
            base.url = '';
            base.caption = '';
            base.ukuran = 'penuh';
        } else if (type === 'kode') {
            base.bahasa = 'php';
            base.kode = '';
        } else if (type === 'link') {
            base.href = '';
            base.label = '';
            base.desc = '';
        } else if (type === 'pembatas') {
            base.style = 'garis';
        }
        this.blocks.push(base);

        const newIndex = this.blocks.length - 1;
        this.$nextTick(() => {
            const el = this.$el.querySelector('#blok-' + newIndex);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = el.querySelector('input[type="text"], textarea');
                if (input) input.focus();
            }
        });
    },

    addBlockAt(type, index) {
        const base = { type };
        if (type === 'subbab') {
            base.judul = '';
        } else if (type === 'subheading') {
            base.teks = '';
        } else if (type === 'paragraf') {
            base.teks = '';
            base.align = 'kiri';
        } else if (type === 'gambar') {
            base.url = '';
            base.caption = '';
            base.ukuran = 'penuh';
        } else if (type === 'kode') {
            base.bahasa = 'php';
            base.kode = '';
        } else if (type === 'link') {
            base.href = '';
            base.label = '';
            base.desc = '';
        } else if (type === 'pembatas') {
            base.style = 'garis';
        }
        this.blocks.splice(index, 0, base);

        this.$nextTick(() => {
            const el = this.$el.querySelector('#blok-' + index);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = el.querySelector('input[type="text"], textarea');
                if (input) input.focus();
            }
        });
    },

    removeBlock(index) {
        this.blocks.splice(index, 1);
    },

    moveBlock(index, direction) {
        const target = index + direction;
        if (target < 0 || target >= this.blocks.length) return;
        const [block] = this.blocks.splice(index, 1);
        this.blocks.splice(target, 0, block);
    },

    // HTML5 Drag & Drop reordering for blocks
    dragStart(index, e) {
        this.draggedIndex = index;
        if (e.dataTransfer) {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', index);
        }
    },

    dragOver(index, e) {
        if (this.draggedIndex === null || this.draggedIndex === index) return;
        e.preventDefault();
    },

    dropBlock(targetIndex, e) {
        if (this.draggedIndex === null || this.draggedIndex === targetIndex) return;
        e.preventDefault();
        const [moved] = this.blocks.splice(this.draggedIndex, 1);
        this.blocks.splice(targetIndex, 0, moved);
        this.draggedIndex = null;
    },

    dragEnd() {
        this.draggedIndex = null;
    },

    async uploadImage(index, file) {
        if (!file) return;

        const name = (file.name || '').toLowerCase();
        const isWebp = file.type === 'image/webp' || name.endsWith('.webp');
        const isSvg = file.type === 'image/svg+xml' || name.endsWith('.svg');

        if (!isWebp && !isSvg) {
            this.uploadError = 'Format gambar ditolak! Hanya file berformat WebP (.webp) atau SVG (.svg) yang diperbolehkan.';
            return;
        }

        this.uploadError = '';
        this.uploadingIndex = index;

        try {
            const formData = new FormData();
            formData.append('gambar', file);

            const res = await fetch(this.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json();
            if (!res.ok || !data.url) {
                throw new Error(data.error || 'Upload gagal');
            }

            this.blocks[index].url = data.url;
        } catch (err) {
            this.uploadError = err.message || 'Upload gambar gagal.';
        } finally {
            this.uploadingIndex = null;
        }
    },
}));

/* ============================================================
   TOC SPY — highlights the current subbab in the right-side
   "Sub Heading" navigation as the reader scrolls (course
   detail page). Used by the right aside via x-data="tocSpy".
   ============================================================ */
Alpine.data('tocSpy', () => ({
    active: '',
    _observer: null,

    init() {
        // Handle TOC link clicks with explicit scroll — native anchor
        // links don't reliably scroll the main document when the link
        // lives inside a fixed, scrollable container.
        this.$el.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="#"]');
            if (!link) return;
            const id = link.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, '', '#' + id);
            }
        });

        this._observe();
    },

    /** (Re-)build the IntersectionObserver for the current TOC links. */
    _observe() {
        if (this._observer) { this._observer.disconnect(); this._observer = null; }

        const ids = Array.from(this.$el.querySelectorAll('a[href^="#"]'))
            .map((a) => a.getAttribute('href').slice(1));
        const sections = ids.map((id) => document.getElementById(id)).filter(Boolean);
        if (!sections.length || typeof IntersectionObserver === 'undefined') return;

        this._observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) this.active = entry.target.id;
                });
            },
            // A heading counts as active when it enters the top band of the
            // viewport (below the floating top bar), not when it's merely
            // visible at the bottom of the screen.
            { rootMargin: '-80px 0px -75% 0px', threshold: 0 }
        );
        sections.forEach((s) => this._observer.observe(s));
    },

    isActive(id) {
        return this.active === id;
    },
}));

/* ============================================================
   COURSE INDEX SEARCH — real-time client-side filtering for the
   course listing page. Input is sanitised to prevent XSS; we only
   compare plain-text strings, never inject user input into the DOM.
   ============================================================ */
Alpine.data('courseSearch', () => ({
    query: '',
    visibleCount: 0,
    _cards: [],
    _texts: [],

    init() {
        const cards = this.$refs.grid.querySelectorAll('.course-card');
        this._cards = Array.from(cards);
        this._texts = this._cards.map((c) => (c.dataset.search || '').toLowerCase());
        this.visibleCount = this._cards.length;
    },

    filter() {
        // Sanitise: strip anything that isn't alphanumeric / whitespace /
        // common accented characters, then collapse whitespace. This
        // prevents injection of HTML entities, script payloads, or
        // regex metacharacters through the search box.
        const raw = this.query || '';
        const safe = raw
            .replace(/<[^>]*>/g, '')        // strip any HTML tags
            .replace(/[&<>"]/g, '')        // strip dangerous chars
            .replace(/\/\/|javascript:/gi, '') // strip protocol/script schemes
            .trim()
            .substring(0, 100);             // hard limit

        const terms = safe.toLowerCase().split(/\s+/).filter(Boolean);

        let count = 0;
        this._cards.forEach((card, i) => {
            const text = this._texts[i];
            const match = terms.length === 0 || terms.every((t) => text.includes(t));
            card.style.display = match ? '' : 'none';
            if (match) count++;
        });
        this.visibleCount = count;
    },
}));

/* ============================================================
   CAROUSEL COMPONENT (snap-scroll grid + pagination dots)
   ============================================================ */
/* Shared snap-carousel logic (dots + pages) used by the plain `carousel`
   component and the filterable `projectGallery` (projects section). */
function carouselCore(totalItems) {
    return {
        totalItems,
        pages: 1,
        current: 1, // 1-based, matching the dots rendered via `x-for="i in pages"`
        gap: 24,

        init() {
        this.calc();
        this.$nextTick(() => this.calc());

        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(() => this.calc()).observe(this.$refs.track);
        }
        window.addEventListener('resize', () => this.calc());

        this.$refs.track.addEventListener('scroll', () => this.onScroll(), { passive: true });
    },

    metrics() {
        const track = this.$refs.track;
        if (!track) return null;
        // Alpine leaves the x-for <template> in the DOM as the first child, so
        // skip it when measuring the first real item (otherwise its zero width
        // breaks the pagination and only one dot ever appears).
        const first = Array.from(track.children).find((el) => el.tagName !== 'TEMPLATE');
        if (!first) return null;
        const gap = parseFloat(getComputedStyle(track).columnGap) || 24;
        const colWidth = first.getBoundingClientRect().width;
        const container = track.getBoundingClientRect().width;
        const step = colWidth + gap;
        const perPage = Math.max(1, Math.floor((container + gap) / step));
        return { gap, step, perPage };
    },

    calc() {
        const track = this.$refs.track;
        if (!track) return;
        const m = this.metrics();
        if (!m) return;
        this.gap = m.gap;
        // Use the real number of rendered items (excluding the x-for template
        // node Alpine keeps in the DOM) so the pagination always matches the
        // actual content, even if the passed total is stale.
        const itemCount = Array.from(track.children).filter((el) => el.tagName !== 'TEMPLATE').length;
        if (itemCount > 0) this.totalItems = itemCount;
        const rows = 2;
        const totalCols = Math.ceil(this.totalItems / rows);
        this.pages = Math.max(1, Math.ceil(totalCols / m.perPage));
        this.current = Math.min(this.current, this.pages);
    },

    onScroll() {
        const m = this.metrics();
        if (!m) return;
        const track = this.$refs.track;
        const maxScroll = track.scrollWidth - track.clientWidth;
        const pos = Math.min(track.scrollLeft, maxScroll);

        // When the end of the track is reached, the last page is fully shown
        // even if it holds fewer columns than a full page — activate its dot.
        if (maxScroll > 0 && pos >= maxScroll - 1) {
            this.current = this.pages;
            return;
        }

        // A dot only becomes active when its panel is actually reached
        // (scrollLeft 0 = page 1), never while the previous panel is still
        // mostly on screen.
        const pageWidth = m.perPage * m.step;
        const page = Math.floor(pos / pageWidth) + 1;
        this.current = Math.max(1, Math.min(page, this.pages));
    },

    go(page) {
        const m = this.metrics();
        if (!m) return;
        this.$refs.track.scrollTo({ left: (page - 1) * m.perPage * m.step, behavior: 'smooth' });
        this.current = page;
    },
    };
}

Alpine.data('carousel', (totalItems) => carouselCore(totalItems));

/* Filterable project gallery: carousel behavior + category filter buttons.
   Reads the projects from window.portfolioData (same source as the root
   `app` component) and re-renders the track when a category is selected. */
Alpine.data('projectGallery', (categories) => ({
    ...carouselCore(0),
    categories: categories || [],
    allProjects: serverData.projects || [],
    category: 'all',

    get visibleProjects() {
        return this.category === 'all'
            ? this.allProjects
            : this.allProjects.filter((p) => p.categoryId === this.category);
    },

    setCategory(cat) {
        this.category = cat;
        this.current = 1;
        const track = this.$refs.track;
        if (track) track.scrollLeft = 0;
        this.$nextTick(() => this.calc());
    },
}));

/* ============================================================
   STICKY PANEL — keeps the right-hand detail-page panel pinned
   at its position for the whole scroll (lg+), so it never scrolls
   away with the page (like the fixed left sidebar on the admin
   pages). The CSS `lg:sticky` fallback can't hold the panel
   beyond its grid cell, so this component takes over with
   `position: fixed` once the panel scrolls past its offset and
   keeps it exactly there until the very bottom.
   ============================================================ */
Alpine.data('stickyPanel', () => ({
    // Matches the `lg:top-28` offset used by the CSS fallback.
    offset: 112,
    enabled: false,
    naturalTop: null,
    width: null,
    height: null,

    init() {
        const mq = window.matchMedia('(min-width: 1024px)');

        const apply = () => {
            this.enabled = mq.matches;
            this.enabled ? this.pin() : this.reset();
        };

        mq.addEventListener('change', apply);
        window.addEventListener('scroll', () => this.pin(), { passive: true });
        window.addEventListener('resize', () => {
            // Re-measure from scratch after a layout change: drop the inline
            // styles first so the element is back in normal flow.
            this.naturalTop = null;
            this.width = null;
            this.height = null;
            this.reset();
            this.pin();
        });

        apply();

        // Re-check after the browser restores the scroll position on reload
        // (restoration happens after Alpine initializes).
        setTimeout(() => this.pin(), 300);
    },

    // Document top of the panel in normal flow, computed from the layout so
    // it is immune to both the `position: sticky` fallback and the AOS
    // entrance transform (which would otherwise corrupt getBoundingClientRect).
    measureNaturalTop() {
        let top = 0;
        let node = this.$el;
        while (node && node.tagName !== 'BODY') {
            top += node.offsetTop || 0;
            node = node.offsetParent;
        }
        return top;
    },

    pin() {
        if (!this.enabled) return;

        const el = this.$el;
        if (!el) return;

        const scrollY = window.pageYOffset || document.documentElement.scrollTop;
        const rect = el.getBoundingClientRect();

        // First measurement happens while the element is still in normal flow
        // — capture its natural position and true size here, because once it
        // becomes `position: fixed` it would shrink-wrap to its content.
        if (this.naturalTop === null) {
            this.naturalTop = this.measureNaturalTop();
            this.width = el.offsetWidth;
            this.height = el.offsetHeight;
        }

        if (scrollY <= this.naturalTop - this.offset) {
            this.reset();
            return;
        }

        // Stay put exactly at the offset for the whole scroll — never ride
        // up past it (that's what pushed the panel off-screen before).
        el.style.position = 'fixed';
        el.style.top = this.offset + 'px';
        // Horizontal position is constant on lg (centered container).
        el.style.left = rect.left + 'px';
        el.style.width = this.width + 'px';

        // If the panel is taller than the space below the navbar, keep the
        // whole panel reachable by scrolling inside it (same pattern as the
        // fixed admin sidebar, which uses overflow-y-auto).
        const maxHeight = window.innerHeight - this.offset - 24;
        if (this.height > maxHeight) {
            el.style.maxHeight = maxHeight + 'px';
            el.style.overflowY = 'auto';
        } else {
            el.style.maxHeight = '';
            el.style.overflowY = '';
        }
    },

    reset() {
        const el = this.$el;
        if (!el) return;
        el.style.position = '';
        el.style.top = '';
        el.style.left = '';
        el.style.width = '';
        el.style.maxHeight = '';
        el.style.overflowY = '';
    },
}));

/* ============================================================
   REORDER TABLE — drag & drop row ordering for admin index tables.
   The tbody is `x-data="reorderTable(url)"`; each row has a
   draggable grip cell and a `data-id`; order is persisted via a
   POST with the new id sequence (1-based sort_order server-side).
   ============================================================ */
Alpine.data('reorderTable', (url) => ({
    url,
    dragging: null,

    updateOrders() {
        const items = Array.from(this.$el.querySelectorAll('[data-id]'));
        items.forEach((item, i) => {
            const nums = item.querySelectorAll('[data-order]');
            nums.forEach((num) => {
                num.textContent = i + 1;
            });
        });
    },

    init() {
        const container = this.$el;
        if (!container) return;

        container.addEventListener('dragstart', (e) => {
            const item = e.target.closest('[data-id]');
            if (!item) return;
            this.dragging = item;
            item.classList.add('opacity-40');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', item.dataset.id);
        });

        container.addEventListener('dragover', (e) => {
            if (!this.dragging) return;
            e.preventDefault();
            const target = e.target.closest('[data-id]');
            if (!target || target === this.dragging) return;
            const rect = target.getBoundingClientRect();
            const afterY = e.clientY > rect.top + rect.height / 2;
            const afterX = e.clientX > rect.left + rect.width / 2;
            const after = afterY || afterX;
            container.insertBefore(this.dragging, after ? target.nextSibling : target);
            this.updateOrders();
        });

        container.addEventListener('drop', (e) => {
            if (!this.dragging) return;
            e.preventDefault();
            this.updateOrders();
            this.save();
        });

        container.addEventListener('dragend', () => {
            if (this.dragging) this.dragging.classList.remove('opacity-40');
            this.dragging = null;
            this.updateOrders();
        });
    },

    async save() {
        const items = Array.from(this.$el.querySelectorAll('[data-id]'));
        const ids = items.map((item) => item.dataset.id);

        this.updateOrders();

        try {
            const res = await fetch(this.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ ids }),
            });
            if (!res.ok) throw new Error('reorder failed');
        } catch (err) {
            // Restore the server-side order if saving failed.
            window.location.reload();
        }
    },
}));

/* ============================================================
   COUNTER COMPONENT (counts up when scrolled into view)
   ============================================================ */
Alpine.data('counter', (target, suffix = '') => ({
    value: 0,
    target,
    suffix,

    init() {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    observer.disconnect();
                    const step = Math.ceil(this.target / (2000 / 16));
                    const timer = setInterval(() => {
                        this.value += step;
                        if (this.value >= this.target) {
                            this.value = this.target;
                            clearInterval(timer);
                        }
                    }, 16);
                }
            },
            { threshold: 0.5 }
        );
        observer.observe(this.$el);
    },
}));

/* ============================================================
   SUBMIT GUARD — prevent duplicate form submissions (especially
   Cloudinary uploads): disable the submit button as soon as the
   form is submitted and show a loading state.
   ============================================================ */
document.addEventListener('submit', (event) => {
    const form = event.target;

    // Skip non-form submits and submissions cancelled by inline
    // handlers (e.g. the delete confirmation `onsubmit`).
    if (!(form instanceof HTMLFormElement) || event.defaultPrevented) {
        return;
    }

    const button = event.submitter || form.querySelector('button[type="submit"]');

    if (!button || button.disabled) {
        return;
    }

    button.disabled = true;
    button.classList.add('cursor-wait', 'opacity-70');

    // Swap the leading icon for a spinner, keeping the button label.
    const icon = button.querySelector('i');
    if (icon) {
        icon.className = 'ri-loader-4-line animate-spin';
    }
});

// Syntax-highlight server-rendered code blocks (course detail page).
document.querySelectorAll('pre > code[class*="language-"]').forEach((el) => hljs.highlightElement(el));

Alpine.start();
