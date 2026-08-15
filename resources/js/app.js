import 'remixicon/fonts/remixicon.css';
import 'animate.css/animate.min.css';
import 'aos/dist/aos.css';
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
        experience: 'Experience',
        projectsBreadcrumb: 'Projects',
        experiencesBreadcrumb: 'Experiences',
        certificatesBreadcrumb: 'Certificates',
        toggleLanguage: 'Switch language',
    },
    id: {
        navHome: 'Beranda',
        navAbout: 'Tentang',
        navSkills: 'Keahlian',
        navProjects: 'Proyek',
        navExperiences: 'Pengalaman',
        navCertificates: 'Sertifikat',
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
        projectsSubtitle: 'Klik salah satu proyek untuk melihat detail lengkap',
        all: 'Semua',
        view: 'Lihat',
        project: 'Proyek',
        myExperience: 'Pengalaman Saya',
        experiencesSubtitle: 'Klik salah satu pengalaman untuk melihat detail lengkap',
        practicumResponsibilities: 'Tanggung Jawab Praktikum',
        keyResponsibilities: 'Tanggung Jawab Utama',
        skillsLabel: 'Keahlian:',
        viewDetails: 'Lihat Detail',
        certificatesAwards: 'Sertifikat & Penghargaan',
        certificatesSubtitle: 'Klik salah satu sertifikat untuk melihat detail lengkap',
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
        experience: 'Pengalaman',
        projectsBreadcrumb: 'Proyek',
        experiencesBreadcrumb: 'Pengalaman',
        certificatesBreadcrumb: 'Sertifikat',
        toggleLanguage: 'Ganti bahasa',
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
    active: 'beranda',
    tools,
    projects,
    experiences,
    certificates,

    init() {
        const stored = localStorage.getItem('theme');
        this.dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', this.dark);

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

        // When arriving with a URL hash (e.g. /#proyek from a detail page
        // navbar click), scroll to that section once the page is ready.
        if (window.location.hash) {
            setTimeout(() => {
                const target = document.querySelector(window.location.hash);
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 200);
        }
    },

    toggleTheme() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
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
        e.preventDefault();
        const el = document.querySelector(href);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else if (window.landingUrl) {
            // Section is not on this page (e.g. project/experience/certificate
            // detail pages) — go to the landing page and scroll to the section.
            window.location.href = window.landingUrl + href;
        }
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

    init() {
        const tbody = this.$el;
        if (!tbody) return;

        tbody.addEventListener('dragstart', (e) => {
            const row = e.target.closest('tr[data-id]');
            if (!row) return;
            this.dragging = row;
            row.classList.add('opacity-40');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', row.dataset.id);
        });

        tbody.addEventListener('dragover', (e) => {
            if (!this.dragging) return;
            e.preventDefault();
            const target = e.target.closest('tr[data-id]');
            if (!target || target === this.dragging) return;
            const rect = target.getBoundingClientRect();
            const after = e.clientY > rect.top + rect.height / 2;
            tbody.insertBefore(this.dragging, after ? target.nextSibling : target);
        });

        tbody.addEventListener('drop', (e) => {
            if (!this.dragging) return;
            e.preventDefault();
            this.save();
        });

        tbody.addEventListener('dragend', () => {
            if (this.dragging) this.dragging.classList.remove('opacity-40');
            this.dragging = null;
        });
    },

    async save() {
        const rows = Array.from(this.$el.querySelectorAll('tr[data-id]'));
        const ids = rows.map((row) => row.dataset.id);

        // Keep the visible row numbers in sync with the new order.
        rows.forEach((row, i) => {
            const num = row.querySelector('[data-order]');
            if (num) num.textContent = i + 1;
        });

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

Alpine.start();
