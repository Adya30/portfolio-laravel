import 'remixicon/fonts/remixicon.css';
import 'animate.css/animate.min.css';
import 'aos/dist/aos.css';

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
import Quill from 'quill';
import './image-uploader';

window.Alpine = Alpine;
window.Quill = Quill;

const serverData = window.portfolioData || {};

const tools = serverData.tools || [];
const projects = serverData.projects || [];
const experiences = serverData.experiences || [];
const certificates = serverData.certificates || [];

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

Alpine.data('app', () => ({
    dark: false,
    scrolled: false,

    
    
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

        
        
        
        this.active = document.body.dataset.activeNav || 'beranda';
        if (window.location.hash && document.querySelector(window.location.hash)) {
            this.active = window.location.hash.slice(1);
        }

        
        
        this.scrolled = window.scrollY > 40;
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 40;
        }, { passive: true });

        
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

        
        AOS.init({ once: true, duration: 800, offset: 40 });

        
        window.addEventListener('popstate', () => {
            if (window.location.pathname.includes('/course/') && window.location.pathname.includes('/subbab/')) {
                this.navigateSubbab(window.location.href);
            } else {
                window.location.reload();
            }
        });

        
        this.$nextTick(() => {
            document.querySelectorAll('pre code').forEach((el) => {
                try {
                    hljs.highlightElement(el);
                } catch (e) {}
            });
        });

        
        
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

    
    
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        try {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                localStorage.setItem('courseSidebar', this.sidebarOpen ? 'open' : 'closed');
            }
        } catch (e) {}
    },

    
    
    
    navigateSubbab(url, event) {
        if (event) event.preventDefault();
        if (this._navigating) return;
        this._navigating = true;

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');

                
                const newMain = doc.querySelector('main');
                const oldMain = document.querySelector('main');
                if (newMain && oldMain) {
                    oldMain.innerHTML = newMain.innerHTML;
                }

                
                
                const oldSidebar = document.querySelector('aside[x-cloak]');
                if (oldSidebar) {
                    const newSidebar = doc.querySelector('aside[x-cloak]');
                    if (newSidebar) {
                        
                        const oldCollapsedLinks = oldSidebar.querySelectorAll('.flex-col.items-center a[href*="/subbab/"]');
                        const newCollapsedLinks = newSidebar.querySelectorAll('.flex-col.items-center a[href*="/subbab/"]');
                        oldCollapsedLinks.forEach((link, i) => {
                            if (newCollapsedLinks[i]) {
                                link.className = newCollapsedLinks[i].className;
                            }
                        });

                        
                        const oldExpandedLinks = oldSidebar.querySelectorAll('.overflow-y-auto a[href*="/subbab/"]');
                        const newExpandedLinks = newSidebar.querySelectorAll('.overflow-y-auto a[href*="/subbab/"]');
                        oldExpandedLinks.forEach((link, i) => {
                            if (newExpandedLinks[i]) {
                                link.className = newExpandedLinks[i].className;
                                
                                const oldSpan = link.querySelector('span');
                                const newSpan = newExpandedLinks[i].querySelector('span');
                                if (oldSpan && newSpan) oldSpan.className = newSpan.className;
                            }
                        });
                    }
                }

                
                const newToc = doc.querySelector('aside[x-data="tocSpy"]');
                const oldToc = document.querySelector('aside[x-data="tocSpy"]');
                if (newToc && oldToc) {
                    oldToc.innerHTML = newToc.innerHTML;
                    oldToc.style.display = '';
                    
                    
                    const tocData = Alpine.$data(oldToc);
                    if (tocData && typeof tocData._observe === 'function') {
                        tocData._observe();
                    }
                } else if (oldToc && !newToc) {
                    oldToc.style.display = 'none';
                }

                
                history.pushState({}, '', url);
                window.scrollTo(0, 0);

                
                if (window.AOS) AOS.refresh();

                
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

    
    t(key) {
        const lang = Alpine.store('lang').current;
        return (i18n[lang] && i18n[lang][key]) || i18n.en[key] || key;
    },

    
    
    
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
            
        }
    },

    
    
    
    
    
    async copyCode(button) {
        
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

function convertHtmlToMarkdown(html) {
    if (!html) return '';

    try {
        const doc = new DOMParser().parseFromString(html, 'text/html');

        function parseNode(node) {
            if (!node) return '';
            if (node.nodeType === Node.TEXT_NODE) {
                return node.textContent;
            }
            if (node.nodeType !== Node.ELEMENT_NODE) {
                return '';
            }

            const tag = node.tagName.toLowerCase();
            const childrenText = Array.from(node.childNodes).map(parseNode).join('');

            switch (tag) {
                case 'h1':
                case 'h2':
                    return `\n\n## ${childrenText.trim()}\n\n`;
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                    return `\n\n### ${childrenText.trim()}\n\n`;
                case 'strong':
                case 'b':
                    return childrenText.trim() ? `**${childrenText.trim()}**` : '';
                case 'em':
                case 'i':
                    return childrenText.trim() ? `*${childrenText.trim()}*` : '';
                case 'u':
                    return childrenText.trim() ? `<u>${childrenText.trim()}</u>` : '';
                case 'del':
                case 's':
                case 'strike':
                    return childrenText.trim() ? `~~${childrenText.trim()}~~` : '';
                case 'code':
                    return node.parentNode && node.parentNode.tagName.toLowerCase() === 'pre'
                        ? childrenText
                        : `\`${childrenText.trim()}\``;
                case 'pre':
                    return `\n\`\`\`\n${childrenText.trim()}\n\`\`\`\n`;
                case 'blockquote':
                    return `\n> ${childrenText.trim().replace(/\n/g, '\n> ')}\n`;
                case 'a':
                    const href = node.getAttribute('href') || '#';
                    return `[${childrenText.trim() || href}](${href})`;
                case 'ul': {
                    const items = Array.from(node.querySelectorAll(':scope > li')).map(li => `- ${parseNode(li).trim()}`);
                    return `\n${items.join('\n')}\n`;
                }
                case 'ol': {
                    const items = Array.from(node.querySelectorAll(':scope > li')).map((li, idx) => `${idx + 1}. ${parseNode(li).trim()}`);
                    return `\n${items.join('\n')}\n`;
                }
                case 'li':
                    return childrenText;
                case 'table': {
                    const rows = Array.from(node.querySelectorAll('tr'));
                    if (rows.length === 0) return '';
                    const tableMatrix = rows.map(r =>
                        Array.from(r.querySelectorAll('th, td')).map(c => parseNode(c).trim().replace(/\|/g, '\\|'))
                    );
                    if (tableMatrix.length === 0) return '';

                    const headerRow = tableMatrix[0];
                    const headerLine = '| ' + headerRow.join(' | ') + ' |';
                    const separatorLine = '| ' + headerRow.map(() => '---').join(' | ') + ' |';
                    const dataLines = tableMatrix.slice(1).map(row => '| ' + row.join(' | ') + ' |');

                    return `\n\n${headerLine}\n${separatorLine}\n${dataLines.join('\n')}\n\n`;
                }
                case 'p':
                case 'div':
                    return `\n${childrenText}\n`;
                case 'br':
                    return '\n';
                case 'hr':
                    return '\n---\n';
                default:
                    return childrenText;
            }
        }

        let result = parseNode(doc.body);
        return result.replace(/\n{3,}/g, '\n\n').trim();
    } catch (e) {
        return '';
    }
}

Alpine.data('courseContentEditor', (initialBlocks = [], uploadUrl = '', autosaveKey = '') => ({
    blocks: Array.isArray(initialBlocks) ? initialBlocks : [],
    uploadUrl,
    uploadingIndex: null,
    uploadError: '',
    draggedIndex: null,
    autosaveKey,
    autosaveStatus: '', // '', 'saving', 'saved', 'recovered'
    _autosaveTimer: null,
    _csrfTimer: null,
    _keydownHandler: null,

    // ── History (Undo / Redo) ──────────────────────────────────
    undoStack: [],
    redoStack: [],
    _isHistoryOp: false,
    _historyDebounce: null,

    snapshot() {
        return JSON.stringify(this.blocks);
    },

    pushHistory() {
        if (this._isHistoryOp) return;
        try {
            const snap = this.snapshot();
            if (this.undoStack.length > 0 && this.undoStack[this.undoStack.length - 1] === snap) {
                return;
            }
            this.undoStack.push(snap);
            if (this.undoStack.length > 50) this.undoStack.shift();
            this.redoStack = [];
        } catch (_) {}
    },

    pushHistoryDebounced() {
        clearTimeout(this._historyDebounce);
        this._historyDebounce = setTimeout(() => {
            this.pushHistory();
        }, 600);
    },

    canUndo() {
        return this.undoStack.length > 0;
    },

    canRedo() {
        return this.redoStack.length > 0;
    },

    undo() {
        if (!this.canUndo()) return;
        this._isHistoryOp = true;
        try {
            const current = this.snapshot();
            this.redoStack.push(current);
            const prev = this.undoStack.pop();
            this.blocks = JSON.parse(prev);
        } catch (_) {}
        setTimeout(() => { this._isHistoryOp = false; }, 50);
    },

    redo() {
        if (!this.canRedo()) return;
        this._isHistoryOp = true;
        try {
            const current = this.snapshot();
            this.undoStack.push(current);
            const next = this.redoStack.pop();
            this.blocks = JSON.parse(next);
        } catch (_) {}
        setTimeout(() => { this._isHistoryOp = false; }, 50);
    },

    init() {
        // ── Scroll to hash block ────────────────────────────────────────
        this.$nextTick(() => {
            const hash = window.location.hash;
            if (!hash) return;
            try {
                const el = this.$el.querySelector(hash);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (_) {}
        });

        // ── Global Keyboard Shortcuts (Ctrl+Z & Ctrl+Y / Ctrl+Shift+Z) ──
        this._keydownHandler = (e) => {
            if (!(e.ctrlKey || e.metaKey)) return;
            const key = e.key.toLowerCase();
            if (key === 'z' && !e.shiftKey) {
                if (!e.target.closest('.ql-editor')) {
                    e.preventDefault();
                    this.undo();
                }
            } else if (key === 'y' || (key === 'z' && e.shiftKey)) {
                if (!e.target.closest('.ql-editor')) {
                    e.preventDefault();
                    this.redo();
                }
            }
        };
        window.addEventListener('keydown', this._keydownHandler);

        // ── Autosave ke localStorage setiap 30 detik ───────────────────
        if (this.autosaveKey) {
            this._autosaveTimer = setInterval(() => {
                try {
                    const payload = {
                        blocks: this.blocks,
                        savedAt: Date.now(),
                    };
                    localStorage.setItem(this.autosaveKey, JSON.stringify(payload));
                    this.autosaveStatus = 'saved';
                    setTimeout(() => { if (this.autosaveStatus === 'saved') this.autosaveStatus = ''; }, 3000);
                } catch (e) {}
            }, 30_000);
        }

        // ── Refresh CSRF token setiap 60 menit ─────────────────────────
        this._csrfTimer = setInterval(async () => {
            try {
                await fetch('/sanctum/csrf-cookie', {
                    method: 'GET',
                    credentials: 'same-origin',
                });
            } catch (_) {}
        }, 60 * 60 * 1000);

        // ── Bersihkan timer & event listener ───────────────────────────
        this.$cleanup = () => {
            if (this._autosaveTimer) clearInterval(this._autosaveTimer);
            if (this._csrfTimer) clearInterval(this._csrfTimer);
            if (this._keydownHandler) window.removeEventListener('keydown', this._keydownHandler);
        };
    },

    /** Hapus draft dari localStorage setelah form berhasil disubmit */
    clearDraft() {
        if (this.autosaveKey) {
            try { localStorage.removeItem(this.autosaveKey); } catch (_) {}
        }
    },

    insertTab(e) {
        const textarea = e.target;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const value = textarea.value;
        this.pushHistory();
        textarea.value = value.substring(0, start) + "    " + value.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + 4;
        textarea.dispatchEvent(new Event('input'));
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
            tabel: 'Tabel Data',
        }[type] || 'Blok';
    },

    addBlock(type) {
        this.pushHistory();
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
        } else if (type === 'tabel') {
            base.headers = ['Header 1', 'Header 2', 'Header 3'];
            base.rows = [
                ['Baris 1 Kolom 1', 'Baris 1 Kolom 2', 'Baris 1 Kolom 3'],
                ['Baris 2 Kolom 1', 'Baris 2 Kolom 2', 'Baris 2 Kolom 3']
            ];
            base.caption = '';
        }
        this.blocks.push(base);

        const newIndex = this.blocks.length - 1;
        this.$nextTick(() => {
            const el = this.$el.querySelector('#blok-' + newIndex);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = el.querySelector('input[type="text"], textarea, .ql-editor');
                if (input) input.focus();
            }
        });
    },

    addBlockAt(type, index) {
        this.pushHistory();
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
        } else if (type === 'tabel') {
            base.headers = ['Header 1', 'Header 2', 'Header 3'];
            base.rows = [
                ['Baris 1 Kolom 1', 'Baris 1 Kolom 2', 'Baris 1 Kolom 3'],
                ['Baris 2 Kolom 1', 'Baris 2 Kolom 2', 'Baris 2 Kolom 3']
            ];
            base.caption = '';
        }
        this.blocks.splice(index, 0, base);

        this.$nextTick(() => {
            const el = this.$el.querySelector('#blok-' + index);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = el.querySelector('input[type="text"], textarea, .ql-editor');
                if (input) input.focus();
            }
        });
    },

    addTableRow(blockIndex) {
        if (!this.blocks[blockIndex] || this.blocks[blockIndex].type !== 'tabel') return;
        this.pushHistory();
        const colCount = (this.blocks[blockIndex].headers || []).length || 1;
        const newRow = Array(colCount).fill('');
        if (!this.blocks[blockIndex].rows) this.blocks[blockIndex].rows = [];
        this.blocks[blockIndex].rows.push(newRow);
    },

    removeTableRow(blockIndex, rowIndex) {
        if (!this.blocks[blockIndex] || this.blocks[blockIndex].type !== 'tabel') return;
        this.pushHistory();
        this.blocks[blockIndex].rows.splice(rowIndex, 1);
    },

    addTableCol(blockIndex) {
        if (!this.blocks[blockIndex] || this.blocks[blockIndex].type !== 'tabel') return;
        this.pushHistory();
        if (!this.blocks[blockIndex].headers) this.blocks[blockIndex].headers = [];
        const nextColNum = this.blocks[blockIndex].headers.length + 1;
        this.blocks[blockIndex].headers.push(`Header ${nextColNum}`);

        (this.blocks[blockIndex].rows || []).forEach(row => {
            row.push('');
        });
    },

    removeTableCol(blockIndex, colIndex) {
        if (!this.blocks[blockIndex] || this.blocks[blockIndex].type !== 'tabel') return;
        if ((this.blocks[blockIndex].headers || []).length <= 1) return;
        this.pushHistory();
        this.blocks[blockIndex].headers.splice(colIndex, 1);
        (this.blocks[blockIndex].rows || []).forEach(row => {
            row.splice(colIndex, 1);
        });
    },

    removeBlock(index) {
        if (index === 0 && this.blocks[0]?.type === 'subbab') return;
        this.pushHistory();
        this.blocks.splice(index, 1);
    },

    moveBlock(index, direction) {
        if (index === 0 && this.blocks[0]?.type === 'subbab') return;
        const target = index + direction;
        if (target < (this.blocks[0]?.type === 'subbab' ? 1 : 0) || target >= this.blocks.length) return;
        this.pushHistory();
        const [block] = this.blocks.splice(index, 1);
        this.blocks.splice(target, 0, block);
    },

    dragStart(index, e) {
        if (index === 0 && this.blocks[0]?.type === 'subbab') {
            e.preventDefault();
            return;
        }
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
        if (this.draggedIndex === 0 && this.blocks[0]?.type === 'subbab') return;
        if (targetIndex === 0 && this.blocks[0]?.type === 'subbab') targetIndex = 1;
        e.preventDefault();
        this.pushHistory();
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

            this.pushHistory();
            this.blocks[index].url = data.url;
        } catch (err) {
            this.uploadError = err.message || 'Upload gambar gagal.';
        } finally {
            this.uploadingIndex = null;
        }
    },

    renderInlineMarkdown(text) {
        if (!text) return '';
        let escaped = String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        // Inline code `code`
        escaped = escaped.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Bold **bold**
        escaped = escaped.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');

        // Italic *italic*
        escaped = escaped.replace(/(?<!\*)\*([^*]+)\*(?!\*)/g, '<em>$1</em>');

        // Line breaks
        escaped = escaped.replace(/\n/g, '<br>');

        return escaped;
    },

    wrapCellWithCode(blockIndex, rIdx, cIdx, textareaEl = null) {
        if (!this.blocks[blockIndex]?.rows?.[rIdx]) return;
        this.pushHistory();

        if (textareaEl && typeof textareaEl.selectionStart === 'number') {
            const start = textareaEl.selectionStart;
            const end = textareaEl.selectionEnd;
            const fullVal = this.blocks[blockIndex].rows[rIdx][cIdx] || '';

            if (start !== end) {
                const selected = fullVal.substring(start, end);
                let replacement;
                if (selected.startsWith('`') && selected.endsWith('`') && selected.length >= 2) {
                    replacement = selected.slice(1, -1);
                } else {
                    replacement = '`' + selected + '`';
                }
                this.blocks[blockIndex].rows[rIdx][cIdx] = fullVal.substring(0, start) + replacement + fullVal.substring(end);
                setTimeout(() => {
                    textareaEl.focus();
                    textareaEl.setSelectionRange(start, start + replacement.length);
                }, 10);
                return;
            }
        }

        let val = (this.blocks[blockIndex].rows[rIdx][cIdx] || '').trim();
        if (val.startsWith('`') && val.endsWith('`') && val.length >= 2) {
            this.blocks[blockIndex].rows[rIdx][cIdx] = val.slice(1, -1);
        } else if (val.length > 0) {
            this.blocks[blockIndex].rows[rIdx][cIdx] = '`' + val + '`';
        } else {
            this.blocks[blockIndex].rows[rIdx][cIdx] = '`kode`';
        }
    },
}));

/* ============================================================
   Quill Rich Text Paragraph Editor Component
   ============================================================ */
Alpine.data('quillParagraphEditor', (block, index) => ({
    quill: null,
    _internalChange: false,

    init() {
        this.$nextTick(() => {
            const box = this.$refs.quillBox;
            if (!box) return;

            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['code'], // Hanya penanda kode inline (`kode`)
                [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }, { 'align': 'justify' }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['blockquote', 'link'],
                ['clean']
            ];

            this.quill = new Quill(box, {
                theme: 'snow',
                placeholder: 'Tulis isi paragraf di sini...',
                modules: {
                    toolbar: toolbarOptions,
                }
            });

            // Beri tooltip ramah pada tombol penanda kode Quill
            const codeBtn = box.parentElement?.querySelector('.ql-code');
            if (codeBtn) {
                codeBtn.setAttribute('title', 'Tanda Kode (</>)');
            }

            // Set initial content
            if (block.teks) {
                if (!block.teks.includes('<') && block.teks.includes('\n')) {
                    this.quill.root.innerHTML = block.teks.split('\n').map(p => p.trim() ? `<p>${p}</p>` : '<p><br></p>').join('');
                } else {
                    this.quill.root.innerHTML = block.teks;
                }
            }

            // Sync to block.teks on user edit
            this.quill.on('text-change', (delta, oldDelta, source) => {
                if (this._internalChange) return;

                const html = this.quill.root.innerHTML;
                const isBlank = html === '<p><br></p>' || this.quill.getText().trim() === '';
                block.teks = isBlank ? '' : html;

                if (source === 'user') {
                    const editorComponent = this.$root.closest('[x-data^="courseContentEditor"]');
                    if (editorComponent && editorComponent._x_dataStack && editorComponent._x_dataStack[0]?.pushHistoryDebounced) {
                        editorComponent._x_dataStack[0].pushHistoryDebounced();
                    }
                }
            });

            // Watch for undo/redo or external block.teks updates
            this.$watch(() => block.teks, (newVal) => {
                if (!this.quill) return;
                const currentHtml = this.quill.root.innerHTML;
                const isBlank = currentHtml === '<p><br></p>' || this.quill.getText().trim() === '';
                const actualCurrent = isBlank ? '' : currentHtml;

                if (newVal !== actualCurrent) {
                    this._internalChange = true;
                    this.quill.root.innerHTML = newVal || '';
                    this.$nextTick(() => {
                        this._internalChange = false;
                    });
                }
            });
        });
    }
}));


Alpine.data('tocSpy', () => ({
    active: '',
    _observer: null,

    init() {
        
        
        
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
            
            
            
            { rootMargin: '-80px 0px -75% 0px', threshold: 0 }
        );
        sections.forEach((s) => this._observer.observe(s));
    },

    isActive(id) {
        return this.active === id;
    },
}));

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
        
        
        
        
        const raw = this.query || '';
        const safe = raw
            .replace(/<[^>]*>/g, '')        
            .replace(/[&<>"]/g, '')        
            .replace(/\/\/|javascript:/gi, '') 
            .trim()
            .substring(0, 100);             

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

function carouselCore(totalItems) {
    return {
        totalItems,
        pages: 1,
        current: 1, 
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

        
        
        if (maxScroll > 0 && pos >= maxScroll - 1) {
            this.current = this.pages;
            return;
        }

        
        
        
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

Alpine.data('stickyPanel', () => ({
    
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
            
            
            this.naturalTop = null;
            this.width = null;
            this.height = null;
            this.reset();
            this.pin();
        });

        apply();

        
        
        setTimeout(() => this.pin(), 300);
    },

    
    
    
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

        
        
        
        if (this.naturalTop === null) {
            this.naturalTop = this.measureNaturalTop();
            this.width = el.offsetWidth;
            this.height = el.offsetHeight;
        }

        if (scrollY <= this.naturalTop - this.offset) {
            this.reset();
            return;
        }

        
        
        el.style.position = 'fixed';
        el.style.top = this.offset + 'px';
        
        el.style.left = rect.left + 'px';
        el.style.width = this.width + 'px';

        
        
        
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
            
            window.location.reload();
        }
    },
}));

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

document.addEventListener('submit', (event) => {
    const form = event.target;

    
    
    if (!(form instanceof HTMLFormElement) || event.defaultPrevented) {
        return;
    }

    const button = event.submitter || form.querySelector('button[type="submit"]');

    if (!button || button.disabled) {
        return;
    }

    button.disabled = true;
    button.classList.add('cursor-wait', 'opacity-70');

    
    const icon = button.querySelector('i');
    if (icon) {
        icon.className = 'ri-loader-4-line animate-spin';
    }
});

document.querySelectorAll('pre > code[class*="language-"]').forEach((el) => hljs.highlightElement(el));

Alpine.start();
