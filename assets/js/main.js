/* ==========================================================================
   Kinetic Editorial – Interaktionen & Motion-Design
   ========================================================================== */
(function () {
    'use strict';

    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const isWide = () => window.innerWidth > 960;

    if (!reducedMotion) document.documentElement.classList.add('morph');

    /* ---------- Cursor ---------- */
    const cursor = $('.cursor');
    if (cursor && finePointer && !reducedMotion) {
        window.addEventListener('pointermove', (e) => {
            cursor.classList.add('is-on');
            cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
        });
        document.addEventListener('pointerleave', () => cursor.classList.remove('is-on'));
        $$('a, button, .panel, .stack-card, .skill, input, textarea').forEach((el) => {
            el.addEventListener('pointerenter', () => cursor.classList.add('is-big'));
            el.addEventListener('pointerleave', () => cursor.classList.remove('is-big'));
        });
    }

    /* ---------- Mobiles Vollbild-Menü ---------- */
    const toggle = $('.menu-toggle');
    const overlay = $('#menu-overlay');

    function setMenu(open) {
        if (!overlay) return;
        if (open) overlay.hidden = false;
        requestAnimationFrame(() => overlay.classList.toggle('is-open', open));
        document.body.classList.toggle('menu-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        $('.menu-label', toggle).textContent = open ? 'Schließen' : 'Menü';
        document.body.style.overflow = open ? 'hidden' : '';
        if (!open) setTimeout(() => { if (!overlay.classList.contains('is-open')) overlay.hidden = true; }, 700);
    }

    toggle?.addEventListener('click', () => setMenu(toggle.getAttribute('aria-expanded') !== 'true'));
    $$('a', overlay).forEach((a) => a.addEventListener('click', () => setMenu(false)));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && overlay?.classList.contains('is-open')) setMenu(false); });

    /* ---------- Hero: Rollen-Schreibmaschine ---------- */
    const rotator = $('.rotator');
    if (rotator && !reducedMotion) {
        let words = [];
        try { words = JSON.parse(rotator.dataset.words || '[]'); } catch (e) { words = []; }
        if (words.length > 1) {
            let w = 0, c = words[0].length, deleting = true;
            const tick = () => {
                c += deleting ? -1 : 1;
                rotator.textContent = words[w].slice(0, c);
                let delay = deleting ? 30 : 65;
                if (!deleting && c === words[w].length) { deleting = true; delay = 2400; }
                else if (deleting && c === 0) { deleting = false; w = (w + 1) % words.length; delay = 300; }
                setTimeout(tick, delay);
            };
            setTimeout(tick, 3000);
        }
    }

    /* ---------- Hero: Bögen folgen der Maus ---------- */
    const arches = $$('#arches .arch');
    if (arches.length && finePointer && !reducedMotion) {
        window.addEventListener('pointermove', (e) => {
            const x = e.clientX / window.innerWidth - 0.5;
            const y = e.clientY / window.innerHeight - 0.5;
            arches.forEach((a) => {
                const d = parseFloat(a.dataset.depth) * 40;
                a.style.transform = `var(--base) translate(${x * d}px, ${y * d}px) rotateY(${x * 10}deg)`;
            });
        });
    }

    /* ---------- Magnetische Elemente ---------- */
    if (finePointer && !reducedMotion) {
        $$('.magnetic, .magnet').forEach((el) => {
            const strength = el.classList.contains('magnet') ? 0.35 : 0.2;
            const inner = el.classList.contains('magnet') ? $('span', el) : null;
            el.addEventListener('pointermove', (e) => {
                const r = el.getBoundingClientRect();
                const dx = e.clientX - r.left - r.width / 2;
                const dy = e.clientY - r.top - r.height / 2;
                el.style.transform = `translate(${dx * strength}px, ${dy * strength}px)`;
                if (inner) inner.style.transform = `translate(${dx * 0.15}px, ${dy * 0.15}px)`;
            });
            el.addEventListener('pointerleave', () => {
                el.style.transform = '';
                if (inner) inner.style.transform = '';
            });
        });
    }

    /* ---------- 3D-Tilt (Ausbildung) ---------- */
    if (finePointer && !reducedMotion) {
        $$('.tilt').forEach((card) => {
            card.addEventListener('pointermove', (e) => {
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                card.style.transform = `rotateY(${x * 12}deg) rotateX(${-y * 12}deg) translateZ(10px)`;
            });
            card.addEventListener('pointerleave', () => { card.style.transform = ''; });
        });
    }

    /* ---------- Über mich: Wörter leuchten beim Scrollen auf ---------- */
    const statement = $('[data-words-reveal]');
    let statementWords = [];
    if (statement) {
        const highlight = /^(Informatikerin|Gesundheitsinformatik|IT-Management|Technologie|Menschen|Technik)/;
        const words = statement.textContent.trim().split(/\s+/);
        statement.textContent = '';
        words.forEach((word, i) => {
            const span = document.createElement('span');
            span.className = 'w' + (highlight.test(word) ? ' hl' : '');
            span.textContent = word;
            statement.appendChild(span);
            if (i < words.length - 1) statement.appendChild(document.createTextNode(' '));
        });
        statementWords = $$('.w', statement);
    }

    /* ---------- Einblendungen beim Scrollen ---------- */
    const counters = $$('[data-count]');
    function runCounter(el) {
        const end = parseInt(el.dataset.count, 10);
        const start = performance.now();
        const step = (now) => {
            const t = Math.min((now - start) / 1500, 1);
            el.textContent = String(Math.round(end * (1 - Math.pow(1 - t, 3))));
            if (t < 1) requestAnimationFrame(step);
        };
        el.textContent = '0';
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window && !reducedMotion) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                $$('[data-count]', entry.target).forEach(runCounter);
                io.unobserve(entry.target);
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
        $$('.reveal').forEach((el) => io.observe(el));
    } else {
        $$('.reveal').forEach((el) => el.classList.add('is-visible'));
        statementWords.forEach((w) => w.classList.add('on'));
        counters.forEach((c) => { c.textContent = c.dataset.count; });
    }

    /* ---------- Scroll-gesteuerte Effekte ---------- */
    const header = $('.site-header');
    const progress = $('.scroll-progress span');
    const zones = $$('[data-bg]');
    const navLinks = $$('[data-nav]');
    const hscroll = $('.hscroll');
    const rail = $('#rail');
    const stackCards = $$('.stack-card');

    const clamp = (v, min = 0, max = 1) => Math.min(Math.max(v, min), max);

    function onScroll() {
        const vh = window.innerHeight;
        const y = window.scrollY;
        const max = document.documentElement.scrollHeight - vh;
        if (progress) progress.style.transform = `scaleX(${max > 0 ? y / max : 0})`;

        // Farbzone & aktiver Menüpunkt
        const line = vh * 0.6;
        const current = zones.find((z) => {
            const r = z.getBoundingClientRect();
            return r.top <= line && r.bottom > line;
        });
        if (current) {
            if (!reducedMotion) document.body.style.backgroundColor = current.dataset.bg;
            document.documentElement.style.setProperty('--header-bg', current.dataset.bg);
            document.body.classList.toggle('on-dark', current.hasAttribute('data-dark'));
            navLinks.forEach((a) => {
                const on = a.dataset.nav === current.id;
                a.classList.toggle('is-active', on);
                if (on) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
            });
        }

        if (reducedMotion) return;

        // Über mich: Wort für Wort
        if (statementWords.length) {
            const r = statement.getBoundingClientRect();
            const p = clamp((vh * 0.85 - r.top) / (r.height + vh * 0.35));
            const count = Math.round(p * statementWords.length);
            statementWords.forEach((w, i) => w.classList.toggle('on', i < count));
        }

        // Kompetenzen: vertikales Scrollen bewegt die Karten horizontal
        if (hscroll && rail) {
            if (isWide()) {
                const r = hscroll.getBoundingClientRect();
                const p = clamp(-r.top / (r.height - vh));
                const distance = rail.scrollWidth - window.innerWidth;
                rail.style.transform = `translate3d(${-p * Math.max(distance, 0)}px, 0, 0)`;
            } else {
                rail.style.transform = '';
            }
        }

        // Stationen: Karten kippen nach hinten, sobald die nächste darüberschiebt
        stackCards.forEach((card, i) => {
            const next = stackCards[i + 1];
            if (!next) return;
            const nr = next.getBoundingClientRect();
            const p = clamp(1 - (nr.top - vh * 0.12) / (vh * 0.75));
            card.style.transform = `scale(${1 - p * 0.07}) rotateX(${p * 10}deg)`;
            card.style.filter = `brightness(${1 - p * 0.35})`;
        });

        header?.classList.toggle('is-scrolled', y > 10);
    }

    let ticking = false;
    const requestTick = () => {
        if (!ticking) { ticking = true; requestAnimationFrame(() => { onScroll(); ticking = false; }); }
    };
    window.addEventListener('scroll', requestTick, { passive: true });
    window.addEventListener('resize', requestTick);
    onScroll();

    /* ---------- Skill-Filter: Kategorie, Erfahrungsstufe & Suche ---------- */
    const search = $('#skill-search');
    const catChips = $$('.chip[data-filter]');
    const levelChips = $$('.chip[data-level]');
    const groups = $$('.skill-group');
    const empty = $('#skill-empty');
    let activeCat = 'all';

    const escapeHtml = (s) => s.replace(/[&<>"']/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]));

    function applySkillFilter() {
        const q = (search?.value || '').trim().toLowerCase();
        const levels = levelChips.filter((c) => c.getAttribute('aria-pressed') === 'true').map((c) => c.dataset.level);
        let total = 0;

        groups.forEach((g) => {
            const catMatch = activeCat === 'all' || g.dataset.category === activeCat;
            let visible = 0;
            $$('.skill', g).forEach((skill) => {
                const nameEl = $('.skill-name', skill);
                const original = nameEl.dataset.original || nameEl.textContent;
                nameEl.dataset.original = original;

                const show = catMatch && levels.includes(skill.dataset.level) && (!q || skill.dataset.name.includes(q));
                skill.hidden = !show;
                if (show) visible++;

                const idx = q && show ? original.toLowerCase().indexOf(q) : -1;
                if (idx >= 0) {
                    nameEl.innerHTML = escapeHtml(original.slice(0, idx)) + '<mark>' + escapeHtml(original.slice(idx, idx + q.length)) + '</mark>' + escapeHtml(original.slice(idx + q.length));
                } else {
                    nameEl.textContent = original;
                }
            });
            g.hidden = visible === 0;
            if (!g.hidden) g.classList.add('is-visible');
            total += visible;
        });

        if (empty) empty.hidden = total > 0;
        requestTick();
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
            field.classList.toggle('has-error', !!text);
            input.setAttribute('aria-invalid', text ? 'true' : 'false');
            $('.field-error', field).textContent = text || '';
        }

        function validateField(name) {
            const input = form.elements[name];
            const valid = input.checkValidity() && input.value.trim().length >= Math.max(input.minLength, 0);
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
            if (!valid) { $('[aria-invalid="true"]', form)?.focus(); return; }

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
