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

        // Navbar shrink on scroll
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
Alpine.data('carousel', (totalItems) => ({
    totalItems,
    pages: 1,
    current: 0,
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
        if (!track || !track.children[0]) return null;
        const gap = parseFloat(getComputedStyle(track).columnGap) || 24;
        const colWidth = track.children[0].getBoundingClientRect().width;
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
        const rows = 2;
        const totalCols = Math.ceil(this.totalItems / rows);
        this.pages = Math.max(1, Math.ceil(totalCols / m.perPage));
        this.current = Math.min(this.current, this.pages - 1);
    },

    onScroll() {
        const m = this.metrics();
        if (!m) return;
        const track = this.$refs.track;
        const idx = Math.round(track.scrollLeft / (m.perPage * m.step));
        this.current = Math.max(0, Math.min(idx, this.pages - 1));
    },

    go(page) {
        const m = this.metrics();
        if (!m) return;
        this.$refs.track.scrollTo({ left: page * m.perPage * m.step, behavior: 'smooth' });
        this.current = page;
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
