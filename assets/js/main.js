/* ==========================================================================
   Interaktionen der Profilseite
   ========================================================================== */
(function () {
    'use strict';

    document.documentElement.classList.add('js');

    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Farbschema (hell/dunkel) ---------- */
    const themeToggle = $('.theme-toggle');
    const root = document.documentElement;

    function currentTheme() {
        const set = root.getAttribute('data-theme');
        if (set) return set;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    themeToggle?.addEventListener('click', () => {
        const next = currentTheme() === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem('theme', next); } catch (e) { /* Speicher nicht verfügbar */ }
    });

    /* ---------- Mobile Navigation ---------- */
    const header = $('.site-header');
    const navToggle = $('.nav-toggle');

    function setNav(open) {
        header.classList.toggle('nav-open', open);
        navToggle.setAttribute('aria-expanded', String(open));
        navToggle.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
    }

    navToggle?.addEventListener('click', () => setNav(!header.classList.contains('nav-open')));
    $$('.nav-links a').forEach((a) => a.addEventListener('click', () => setNav(false)));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setNav(false); });
    document.addEventListener('click', (e) => {
        if (header.classList.contains('nav-open') && !header.contains(e.target)) setNav(false);
    });

    /* ---------- Scroll: Header-Schatten, Fortschritt, Nach-oben-Button ---------- */
    const progress = $('.scroll-progress span');
    const toTop = $('.to-top');
    let ticking = false;

    function onScroll() {
        const y = window.scrollY;
        const max = document.documentElement.scrollHeight - window.innerHeight;
        header.classList.toggle('is-scrolled', y > 10);
        if (progress) progress.style.transform = `scaleX(${max > 0 ? y / max : 0})`;
        toTop?.classList.toggle('is-visible', y > window.innerHeight * 0.8);
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) { requestAnimationFrame(onScroll); ticking = true; }
    }, { passive: true });
    onScroll();

    toTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' }));

    /* ---------- Aktiver Navigationspunkt ---------- */
    const navLinks = $$('[data-nav]');
    const sections = navLinks.map((a) => document.getElementById(a.dataset.nav)).filter(Boolean);

    if ('IntersectionObserver' in window && sections.length) {
        const navObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                navLinks.forEach((a) => {
                    const active = a.dataset.nav === entry.target.id;
                    a.classList.toggle('is-active', active);
                    if (active) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
                });
            });
        }, { rootMargin: '-45% 0px -50% 0px' });
        sections.forEach((s) => navObserver.observe(s));
    }

    /* ---------- Einblend-Animationen ---------- */
    const revealEls = $$('.reveal');
    if ('IntersectionObserver' in window && !reducedMotion) {
        const revealObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach((el) => revealObserver.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('is-visible'));
    }

    /* ---------- Rotierende Rollen im Hero (Schreibmaschinen-Effekt) ---------- */
    const rotator = $('.rotator');
    if (rotator) {
        let words = [];
        try { words = JSON.parse(rotator.dataset.words || '[]'); } catch (e) { words = []; }

        if (words.length > 1 && !reducedMotion) {
            let w = 0, c = words[0].length, deleting = true;
            const tick = () => {
                const word = words[w];
                c += deleting ? -1 : 1;
                rotator.textContent = word.slice(0, c);
                let delay = deleting ? 35 : 70;
                if (!deleting && c === word.length) { deleting = true; delay = 2200; }
                else if (deleting && c === 0) { deleting = false; w = (w + 1) % words.length; delay = 350; }
                setTimeout(tick, delay);
            };
            setTimeout(tick, 2500);
        }
    }

    /* ---------- Tabs (Kompetenzfelder) mit Tastatursteuerung ---------- */
    $$('[data-tabs]').forEach((tabsEl) => {
        const tabs = $$('[role="tab"]', tabsEl);
        const panels = $$('[role="tabpanel"]', tabsEl);

        function select(tab, focus = true) {
            tabs.forEach((t) => {
                const on = t === tab;
                t.setAttribute('aria-selected', String(on));
                t.tabIndex = on ? 0 : -1;
            });
            panels.forEach((p) => { p.hidden = p.id !== tab.getAttribute('aria-controls'); });
            if (focus) tab.focus();
            tab.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: reducedMotion ? 'auto' : 'smooth' });
        }

        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => select(tab, false));
            tab.addEventListener('keydown', (e) => {
                const keys = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 };
                if (e.key in keys) {
                    e.preventDefault();
                    select(tabs[(i + keys[e.key] + tabs.length) % tabs.length]);
                } else if (e.key === 'Home') { e.preventDefault(); select(tabs[0]); }
                else if (e.key === 'End') { e.preventDefault(); select(tabs[tabs.length - 1]); }
            });
        });
    });

    /* ---------- Skill-Filter: Kategorie, Erfahrungsstufe & Suche ---------- */
    const search = $('#skill-search');
    const catChips = $$('.chip[data-filter]');
    const levelChips = $$('.chip[data-level]');
    const groups = $$('.skill-group');
    const empty = $('#skill-empty');
    let activeCat = 'all';

    function escapeHtml(s) {
        return s.replace(/[&<>"']/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]));
    }

    function applySkillFilter() {
        const q = (search?.value || '').trim().toLowerCase();
        const levels = levelChips.filter((c) => c.getAttribute('aria-pressed') === 'true').map((c) => c.dataset.level);
        let visibleTotal = 0;

        groups.forEach((g) => {
            const catMatch = activeCat === 'all' || g.dataset.category === activeCat;
            let visibleInGroup = 0;

            $$('.skill', g).forEach((skill) => {
                const nameEl = $('.skill-name', skill);
                const original = nameEl.dataset.original || nameEl.textContent;
                nameEl.dataset.original = original;

                const show = catMatch && levels.includes(skill.dataset.level) && (!q || skill.dataset.name.includes(q));
                skill.hidden = !show;
                if (show) visibleInGroup++;

                // Treffer hervorheben
                if (q && show) {
                    const idx = original.toLowerCase().indexOf(q);
                    nameEl.innerHTML = idx < 0 ? escapeHtml(original)
                        : escapeHtml(original.slice(0, idx)) + '<mark>' + escapeHtml(original.slice(idx, idx + q.length)) + '</mark>' + escapeHtml(original.slice(idx + q.length));
                } else {
                    nameEl.textContent = original;
                }
            });

            g.hidden = visibleInGroup === 0;
            if (!g.hidden) g.classList.add('is-visible');
            visibleTotal += visibleInGroup;
        });

        if (empty) empty.hidden = visibleTotal > 0;
    }

    catChips.forEach((chip) => chip.addEventListener('click', () => {
        activeCat = chip.dataset.filter;
        catChips.forEach((c) => {
            const on = c === chip;
            c.classList.toggle('is-active', on);
            c.setAttribute('aria-pressed', String(on));
        });
        applySkillFilter();
    }));

    levelChips.forEach((chip) => chip.addEventListener('click', () => {
        const pressed = chip.getAttribute('aria-pressed') === 'true';
        const othersOn = levelChips.filter((c) => c !== chip && c.getAttribute('aria-pressed') === 'true').length;
        if (pressed && othersOn === 0) return; // mindestens eine Stufe bleibt aktiv
        chip.setAttribute('aria-pressed', String(!pressed));
        applySkillFilter();
    }));

    search?.addEventListener('input', applySkillFilter);

    /* ---------- Zähler-Animation (Masterarbeit) ---------- */
    const counters = $$('[data-count]');
    if ('IntersectionObserver' in window && !reducedMotion) {
        const countObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseInt(el.dataset.count, 10);
                const start = performance.now();
                const duration = 1400;
                const step = (now) => {
                    const t = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - t, 3);
                    el.textContent = Math.round(target * eased);
                    if (t < 1) requestAnimationFrame(step);
                };
                el.textContent = '0';
                requestAnimationFrame(step);
                obs.unobserve(el);
            });
        }, { threshold: 0.6 });
        counters.forEach((c) => countObserver.observe(c));
    }

    /* ---------- Flip-Karten (Touch & Tastatur) ---------- */
    $$('.flip-inner').forEach((btn) => btn.addEventListener('click', () => {
        btn.setAttribute('aria-pressed', String(btn.getAttribute('aria-pressed') !== 'true'));
    }));

    /* ---------- Kontaktformular: Validierung & Versand per fetch ---------- */
    const form = $('#contact-form');
    if (form) {
        const status = $('.form-status', form);
        const submit = $('button[type="submit"]', form);
        const message = $('#f-message', form);
        const counter = $('#char-count', form);

        const messages = {
            name: 'Bitte gib deinen Namen an (2–100 Zeichen).',
            email: 'Bitte gib eine gültige E-Mail-Adresse an.',
            message: 'Die Nachricht sollte zwischen 10 und 5000 Zeichen lang sein.',
        };

        const updateCounter = () => { if (counter) counter.textContent = `${message.value.length} / 5000`; };
        message?.addEventListener('input', updateCounter);
        updateCounter();

        function setFieldError(name, text) {
            const input = form.elements[name];
            const field = input.closest('.field');
            const err = $('.field-error', field);
            field.classList.toggle('has-error', !!text);
            input.setAttribute('aria-invalid', text ? 'true' : 'false');
            err.textContent = text || '';
        }

        function validateField(name) {
            const input = form.elements[name];
            input.value = name === 'message' ? input.value : input.value.trimStart();
            const valid = input.checkValidity() && input.value.trim().length >= (input.minLength > 0 ? input.minLength : 0);
            setFieldError(name, valid ? '' : messages[name]);
            return valid;
        }

        ['name', 'email', 'message'].forEach((name) => {
            form.elements[name].addEventListener('blur', () => validateField(name));
            form.elements[name].addEventListener('input', () => {
                if (form.elements[name].closest('.field').classList.contains('has-error')) validateField(name);
            });
        });

        function showStatus(ok, text) {
            status.hidden = false;
            status.textContent = text;
            status.classList.toggle('is-success', ok);
            status.classList.toggle('is-error', !ok);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const valid = ['name', 'email', 'message'].map(validateField).every(Boolean);
            if (!valid) {
                form.querySelector('[aria-invalid="true"]')?.focus();
                return;
            }

            submit.classList.add('is-loading');
            submit.disabled = true;
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json();
                Object.entries(data.errors || {}).forEach(([k, v]) => setFieldError(k, v));
                showStatus(data.ok, data.message);
                if (data.ok) { form.reset(); updateCounter(); }
            } catch (err) {
                showStatus(false, 'Die Nachricht konnte nicht gesendet werden. Bitte versuche es später erneut.');
            } finally {
                submit.classList.remove('is-loading');
                submit.disabled = false;
            }
        });
    }
})();
