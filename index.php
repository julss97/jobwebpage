<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
$p = require __DIR__ . '/data/profile.php';

$person = $p['person'];
$flash  = $_SESSION['contact_flash'] ?? null;
unset($_SESSION['contact_flash']);
$old    = $flash['old'] ?? [];
$errors = $flash['errors'] ?? [];

$nav = [
    'ueber-mich'  => 'Über mich',
    'kompetenzen' => 'Kompetenzen',
    'skills'      => 'Skills',
    'werdegang'   => 'Werdegang',
    'masterarbeit'=> 'Masterarbeit',
    'kontakt'     => 'Kontakt',
];

$skillCount = array_sum(array_map('count', $p['skills']));
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($p['meta']['title']) ?></title>
    <meta name="description" content="<?= e($p['meta']['description']) ?>">
    <meta name="theme-color" content="#621E3E">
    <link rel="icon" href="assets/img/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        // Theme vor dem ersten Rendern setzen, um Flackern zu vermeiden.
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t) document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>
</head>
<body>
<a class="skip-link" href="#main">Zum Inhalt springen</a>

<header class="site-header" id="top">
    <nav class="nav container" aria-label="Hauptnavigation">
        <a class="brand" href="#top" aria-label="Zum Seitenanfang">
            <span class="brand-mark"><?= e(initials($person['name'])) ?></span>
            <span class="brand-name"><?= e($person['name']) ?></span>
        </a>

        <ul class="nav-links" id="nav-links">
            <?php foreach ($nav as $id => $label): ?>
                <li><a href="#<?= e($id) ?>" data-nav="<?= e($id) ?>"><?= e($label) ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="nav-actions">
            <button class="icon-btn theme-toggle" type="button" aria-label="Farbschema wechseln">
                <?= icon('moon', 'icon icon-moon') ?><?= icon('sun', 'icon icon-sun') ?>
            </button>
            <button class="icon-btn nav-toggle" type="button" aria-label="Menü öffnen" aria-expanded="false" aria-controls="nav-links">
                <?= icon('menu', 'icon icon-open') ?><?= icon('close', 'icon icon-close') ?>
            </button>
        </div>
    </nav>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>
</header>

<main id="main">

    <!-- ============ HERO ============ -->
    <section class="hero">
        <div class="hero-bg" aria-hidden="true">
            <span class="blob blob-1"></span><span class="blob blob-2"></span><span class="blob blob-3"></span>
        </div>
        <div class="container hero-grid">
            <div class="hero-text">
                <p class="eyebrow"><?= e($p['hero']['greeting']) ?></p>
                <h1><?= e($person['name']) ?></h1>
                <p class="hero-rotator" aria-live="polite">
                    <span class="rotator" data-words='<?= e(json_encode($p['hero']['rotating'], JSON_UNESCAPED_UNICODE)) ?>'><?= e($p['hero']['rotating'][0]) ?></span><span class="caret" aria-hidden="true"></span>
                </p>
                <p class="hero-claim"><?= e($p['hero']['claim']) ?></p>
                <div class="hero-cta">
                    <a class="btn btn-primary" href="#kontakt"><?= icon('mail') ?> Kontakt aufnehmen</a>
                    <a class="btn btn-ghost" href="#skills">Skills entdecken</a>
                </div>
                <ul class="hero-meta">
                    <li><?= icon('cap') ?> M.Sc. Informatik · B.Sc. Gesundheitsinformatik</li>
                    <li><?= icon('globe') ?>
                        <?= e(implode(' · ', array_map(fn($l) => $l['name'] . ' (' . $l['level'] . ')', $person['languages']))) ?>
                    </li>
                </ul>
            </div>

            <div class="hero-photo">
                <div class="photo-frame">
                    <?php if (!empty($person['photo'])): ?>
                        <img src="<?= e($person['photo']) ?>" alt="Porträt von <?= e($person['name']) ?>" width="420" height="420">
                    <?php else: ?>
                        <!-- Platzhalter: In data/profile.php unter person.photo den Bildpfad eintragen. -->
                        <div class="photo-placeholder" role="img" aria-label="Platzhalter für ein Porträtfoto">
                            <span class="photo-initials"><?= e(initials($person['name'])) ?></span>
                            <span class="photo-hint"><?= icon('camera') ?> Platz für dein Foto</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="photo-badge photo-badge-1"><?= icon('heart') ?> Healthcare IT</div>
                <div class="photo-badge photo-badge-2"><?= icon('spark') ?> Daten &amp; KI</div>
            </div>
        </div>
        <a class="scroll-hint" href="#ueber-mich" aria-label="Weiter zu Über mich"><?= icon('chevron') ?></a>
    </section>

    <!-- ============ ÜBER MICH ============ -->
    <section class="section" id="ueber-mich">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">01</span>
                <h2>Über mich</h2>
                <p class="section-lead"><?= e($p['about']['lead']) ?></p>
            </header>

            <div class="about-grid">
                <div class="about-text reveal">
                    <?php foreach ($p['about']['paragraphs'] as $para): ?>
                        <p><?= e($para) ?></p>
                    <?php endforeach; ?>
                    <blockquote class="quote"><?= e($p['closing']) ?></blockquote>
                </div>
                <ul class="highlight-cards">
                    <?php foreach ($p['about']['highlights'] as $i => $h): ?>
                        <li class="card highlight reveal" style="--delay: <?= $i * 80 ?>ms">
                            <span class="highlight-icon"><?= icon($h['icon']) ?></span>
                            <h3><?= e($h['title']) ?></h3>
                            <p><?= e($h['text']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============ KOMPETENZEN (Tabs) ============ -->
    <section class="section section-tinted" id="kompetenzen">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">02</span>
                <h2>Kompetenzfelder</h2>
                <p class="section-lead">An der Schnittstelle zwischen Entwicklung, Fachbereichen und Nutzer:innen.</p>
            </header>

            <div class="tabs reveal" data-tabs>
                <div class="tab-list" role="tablist" aria-label="Kompetenzfelder">
                    <?php foreach ($p['competencies'] as $i => $c): ?>
                        <button class="tab" role="tab" type="button"
                                id="tab-<?= e($c['id']) ?>"
                                aria-controls="panel-<?= e($c['id']) ?>"
                                aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                                tabindex="<?= $i === 0 ? '0' : '-1' ?>">
                            <?= e($c['title']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php foreach ($p['competencies'] as $i => $c): ?>
                    <div class="tab-panel" role="tabpanel"
                         id="panel-<?= e($c['id']) ?>"
                         aria-labelledby="tab-<?= e($c['id']) ?>"
                         tabindex="0" <?= $i === 0 ? '' : 'hidden' ?>>
                        <h3><?= e($c['title']) ?></h3>
                        <p><?= e($c['text']) ?></p>
                        <ul class="check-list">
                            <?php foreach ($c['points'] as $pt): ?>
                                <li><?= icon('check') ?><?= e($pt) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ SKILLS (Filter + Suche) ============ -->
    <section class="section" id="skills">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">03</span>
                <h2>Werkzeuge &amp; Technologien</h2>
                <p class="section-lead">
                    <?= (int) $skillCount ?> Werkzeuge, Methoden und Technologien – mit ehrlicher Einordnung,
                    wie tief meine Erfahrung jeweils reicht.
                </p>
            </header>

            <div class="skill-controls reveal">
                <label class="search">
                    <?= icon('search') ?>
                    <span class="visually-hidden">Skills durchsuchen</span>
                    <input type="search" id="skill-search" placeholder="Skill suchen, z. B. SQL oder FHIR" autocomplete="off">
                </label>
                <div class="chips" role="group" aria-label="Nach Kategorie filtern">
                    <button class="chip is-active" type="button" data-filter="all" aria-pressed="true">Alle</button>
                    <?php foreach (array_keys($p['skills']) as $cat): ?>
                        <button class="chip" type="button" data-filter="<?= e(slug($cat)) ?>" aria-pressed="false"><?= e($cat) ?></button>
                    <?php endforeach; ?>
                </div>
                <div class="chips chips-level" role="group" aria-label="Nach Erfahrungsstufe filtern">
                    <?php foreach ($p['skill_levels'] as $lvl => $label): ?>
                        <button class="chip chip-level" type="button" data-level="<?= (int) $lvl ?>" aria-pressed="true">
                            <span class="dots" data-level="<?= (int) $lvl ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                            <?= e($label) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="skill-groups" id="skill-groups">
                <?php foreach ($p['skills'] as $cat => $items): ?>
                    <div class="skill-group card reveal" data-category="<?= e(slug($cat)) ?>">
                        <h3><?= e($cat) ?></h3>
                        <ul class="skill-list">
                            <?php foreach ($items as $s): ?>
                                <li class="skill" data-level="<?= (int) $s['level'] ?>" data-name="<?= e(mb_strtolower($s['name'])) ?>"
                                    title="<?= e($p['skill_levels'][$s['level']]) ?>">
                                    <span class="dots" data-level="<?= (int) $s['level'] ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                                    <span class="skill-name"><?= e($s['name']) ?></span>
                                    <span class="visually-hidden">(<?= e($p['skill_levels'][$s['level']]) ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="skill-empty" id="skill-empty" hidden>Keine passenden Skills gefunden – probiere einen anderen Suchbegriff.</p>
        </div>
    </section>

    <!-- ============ WERDEGANG ============ -->
    <section class="section section-tinted" id="werdegang">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">04</span>
                <h2>Werdegang</h2>
                <p class="section-lead">Von Softwareentwicklung über Produktion und IT-Support bis zum direkten Kundenkontakt.</p>
            </header>

            <div class="career-grid">
                <div>
                    <h3 class="column-title"><?= icon('briefcase') ?> Berufliche Stationen</h3>
                    <ol class="timeline">
                        <?php foreach ($p['experience'] as $i => $job): ?>
                            <li class="timeline-item reveal">
                                <details class="job" <?= $i === 0 ? 'open' : '' ?>>
                                    <summary>
                                        <span class="job-head">
                                            <span class="job-company"><?= e($job['company']) ?></span>
                                            <span class="job-role"><?= e($job['role']) ?></span>
                                            <?php if (!empty($job['period'])): ?>
                                                <span class="job-period"><?= e($job['period']) ?></span>
                                            <?php endif; ?>
                                        </span>
                                        <?= icon('chevron', 'icon job-chevron') ?>
                                    </summary>
                                    <div class="job-body">
                                        <p><?= e($job['summary']) ?></p>
                                        <ul class="check-list">
                                            <?php foreach ($job['points'] as $pt): ?>
                                                <li><?= icon('check') ?><?= e($pt) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <ul class="tags">
                                            <?php foreach ($job['tags'] as $t): ?>
                                                <li><?= e($t) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </details>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <div>
                    <h3 class="column-title"><?= icon('cap') ?> Ausbildung</h3>
                    <?php foreach ($p['education'] as $edu): ?>
                        <article class="card edu reveal">
                            <p class="edu-school"><?= e($edu['school']) ?></p>
                            <h4><?= e($edu['degree']) ?></h4>
                            <p class="edu-focus"><?= e($edu['focus']) ?></p>
                            <p><?= e($edu['text']) ?></p>
                            <ul class="tags">
                                <?php foreach ($edu['tags'] as $t): ?>
                                    <li><?= e($t) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>

                    <article class="card languages reveal">
                        <h4><?= icon('globe') ?> Sprachen</h4>
                        <ul>
                            <?php foreach ($person['languages'] as $l): ?>
                                <li><span><?= e($l['name']) ?></span><strong><?= e($l['level']) ?></strong></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ MASTERARBEIT ============ -->
    <section class="section thesis-section" id="masterarbeit">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">05</span>
                <h2>Masterarbeit</h2>
            </header>

            <div class="thesis card reveal">
                <div class="thesis-main">
                    <span class="thesis-icon"><?= icon('book') ?></span>
                    <h3>„<?= e($p['thesis']['title']) ?>“</h3>
                    <p><?= e($p['thesis']['text']) ?></p>
                    <div class="thesis-cols">
                        <div>
                            <h4>Konzepte</h4>
                            <ul class="tags"><?php foreach ($p['thesis']['concepts'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
                        </div>
                        <div>
                            <h4>Methodik</h4>
                            <ul class="tags tags-alt"><?php foreach ($p['thesis']['methods'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
                        </div>
                    </div>
                </div>
                <ul class="stats">
                    <?php foreach ($p['thesis']['stats'] as $s): ?>
                        <li>
                            <span class="stat-value" data-count="<?= (int) $s['value'] ?>"><?= (int) $s['value'] ?></span>
                            <span class="stat-label"><?= e($s['label']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============ STÄRKEN & INTERESSEN ============ -->
    <section class="section section-tinted" id="staerken">
        <div class="container">
            <header class="section-head reveal">
                <span class="section-kicker">06</span>
                <h2>Arbeitsweise &amp; Stärken</h2>
                <p class="section-lead">Technische Details verstehen – und das größere Ganze im Blick behalten.</p>
            </header>

            <ul class="strengths">
                <?php foreach ($p['strengths'] as $i => $s): ?>
                    <li class="flip reveal" style="--delay: <?= ($i % 3) * 80 ?>ms">
                        <button class="flip-inner" type="button" aria-pressed="false">
                            <span class="flip-front">
                                <span class="flip-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                <span class="flip-title"><?= e($s['title']) ?></span>
                                <span class="flip-more">mehr erfahren</span>
                            </span>
                            <span class="flip-back"><?= e($s['text']) ?></span>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="interests reveal">
                <h3>Was mich fachlich besonders interessiert</h3>
                <ul class="interest-cloud">
                    <?php foreach ($p['interests'] as $int): ?>
                        <li><?= e($int) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============ KONTAKT ============ -->
    <section class="section contact-section" id="kontakt">
        <div class="container contact-grid">
            <div class="contact-intro reveal">
                <span class="section-kicker">07</span>
                <h2>Lass uns sprechen</h2>
                <p>
                    Du suchst Unterstützung in Healthcare IT, IT-Beratung, Schnittstellenintegration,
                    Prozessautomatisierung, UX/UI oder Produktmanagement? Ich freue mich auf deine Nachricht.
                </p>
                <ul class="contact-list">
                    <li><?= icon('mail') ?><a href="mailto:<?= e($person['email']) ?>"><?= e($person['email']) ?></a></li>
                    <?php if (!empty($person['location'])): ?>
                        <li><?= icon('pin') ?><span><?= e($person['location']) ?></span></li>
                    <?php endif; ?>
                    <?php if (!empty($person['linkedin'])): ?>
                        <li><?= icon('linkedin') ?><a href="<?= e($person['linkedin']) ?>" rel="noopener" target="_blank">LinkedIn</a></li>
                    <?php endif; ?>
                    <?php if (!empty($person['github'])): ?>
                        <li><?= icon('github') ?><a href="<?= e($person['github']) ?>" rel="noopener" target="_blank">GitHub</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <form class="contact-form card reveal" action="contact.php" method="post" novalidate id="contact-form">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <div class="hp" aria-hidden="true">
                    <label>Webseite <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="form-status <?= $flash ? ($flash['ok'] ? 'is-success' : 'is-error') : '' ?>" role="status" aria-live="polite"
                    <?= $flash ? '' : 'hidden' ?>><?= e($flash['message'] ?? '') ?></div>

                <div class="field">
                    <label for="f-name">Name</label>
                    <input id="f-name" name="name" type="text" required minlength="2" maxlength="100" autocomplete="name"
                           value="<?= e($old['name'] ?? '') ?>" aria-describedby="err-name">
                    <span class="field-error" id="err-name"><?= e($errors['name'] ?? '') ?></span>
                </div>
                <div class="field">
                    <label for="f-email">E-Mail</label>
                    <input id="f-email" name="email" type="email" required maxlength="200" autocomplete="email"
                           value="<?= e($old['email'] ?? '') ?>" aria-describedby="err-email">
                    <span class="field-error" id="err-email"><?= e($errors['email'] ?? '') ?></span>
                </div>
                <div class="field">
                    <label for="f-message">Nachricht</label>
                    <textarea id="f-message" name="message" rows="5" required minlength="10" maxlength="5000"
                              aria-describedby="err-message"><?= e($old['message'] ?? '') ?></textarea>
                    <span class="field-meta"><span class="field-error" id="err-message"><?= e($errors['message'] ?? '') ?></span><span class="char-count" id="char-count">0 / 5000</span></span>
                </div>
                <button class="btn btn-primary btn-block" type="submit">
                    <span class="btn-label">Nachricht senden</span><span class="spinner" aria-hidden="true"></span>
                </button>
            </form>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; <?= date('Y') ?> <?= e($person['name']) ?> · <?= e($person['role']) ?></p>
        <p class="footer-colors" aria-hidden="true"><i></i><i></i><i></i></p>
        <a href="#top" class="footer-top">Nach oben <?= icon('arrow-up') ?></a>
    </div>
</footer>

<button class="to-top" type="button" aria-label="Nach oben scrollen"><?= icon('arrow-up') ?></button>

<script src="assets/js/main.js" defer></script>
</body>
</html>
