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
    'ueber-mich'   => 'Über mich',
    'kompetenzen'  => 'Kompetenzen',
    'skills'       => 'Skills',
    'stationen'    => 'Stationen',
    'masterarbeit' => 'Masterarbeit',
    'kontakt'      => 'Kontakt',
];

$skillCount = array_sum(array_map('count', $p['skills']));

// Alle Skill-Namen für die Laufbänder
$ribbonA = array_column(array_merge($p['skills']['Programmierung'], $p['skills']['APIs & Integration']), 'name');
$ribbonB = array_column(array_merge($p['skills']['Data Science & ML'], $p['skills']['UX/UI & Produkt']), 'name');

[$firstName, $lastName] = array_pad(explode(' ', $person['name'], 2), 2, '');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($p['meta']['title']) ?></title>
    <meta name="description" content="<?= e($p['meta']['description']) ?>">
    <meta name="theme-color" content="#7E0B45">
    <link rel="icon" href="assets/img/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>document.documentElement.classList.add('js');</script>
</head>
<body>
<a class="skip-link" href="#main">Zum Inhalt springen</a>
<div class="cursor" aria-hidden="true"></div>

<header class="site-header">
    <a class="brand" href="#top" aria-label="Zum Seitenanfang"><?= e(initials($person['name'])) ?>.</a>
    <nav class="nav-desktop" aria-label="Hauptnavigation">
        <?php foreach ($nav as $id => $label): ?>
            <a href="#<?= e($id) ?>" data-nav="<?= e($id) ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </nav>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="menu-overlay">
        <span class="menu-label">Menü</span><span class="menu-icon" aria-hidden="true"><i></i><i></i></span>
    </button>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>
</header>

<div class="menu-overlay" id="menu-overlay" hidden>
    <nav aria-label="Mobile Navigation">
        <?php $i = 0; foreach ($nav as $id => $label): ?>
            <a href="#<?= e($id) ?>" style="--i: <?= $i++ ?>"><span><?= str_pad((string) $i, 2, '0', STR_PAD_LEFT) ?></span><?= e($label) ?></a>
        <?php endforeach; ?>
    </nav>
</div>

<main id="main">

    <!-- ============ HERO ============ -->
    <section class="hero zone" id="top" data-bg="#fff6ef">
        <div class="hero-text">
            <p class="eyebrow reveal-fade"><?= e($p['hero']['greeting']) ?></p>
            <h1 class="big-type">
                <span class="line"><span><?= e($firstName) ?></span></span>
                <span class="line"><span><?= e($lastName) ?>.</span></span>
            </h1>
            <p class="hero-sub reveal-fade"><i aria-hidden="true"></i>
                <span class="rotator" data-words='<?= e(json_encode($p['hero']['rotating'], JSON_UNESCAPED_UNICODE)) ?>'><?= e($p['hero']['rotating'][0]) ?></span>
            </p>
            <p class="hero-claim reveal-fade"><?= e($p['hero']['claim']) ?></p>
            <div class="hero-cta reveal-fade">
                <a class="btn btn-dark magnetic" href="#kontakt"><?= icon('mail') ?> Kontakt aufnehmen</a>
                <a class="btn btn-outline magnetic" href="#skills">Skills entdecken</a>
            </div>
        </div>

        <div class="arch-stack" id="arches">
            <div class="arch arch-1" data-depth="0.6"></div>
            <div class="arch arch-2" data-depth="1"></div>
            <div class="arch arch-photo" data-depth="0.25">
                <?php if (!empty($person['photo'])): ?>
                    <img src="<?= e($person['photo']) ?>" alt="Porträt von <?= e($person['name']) ?>">
                <?php else: ?>
                    <!-- Platzhalter: In data/profile.php unter person.photo den Bildpfad eintragen. -->
                    <div class="photo-placeholder" role="img" aria-label="Platzhalter für ein Porträtfoto">
                        <span class="initials"><?= e(initials($person['name'])) ?></span>
                        <span class="hint"><?= icon('camera') ?> Platz für dein Foto</span>
                    </div>
                <?php endif; ?>
            </div>
            <svg class="sticker" viewBox="0 0 120 120" aria-hidden="true">
                <circle cx="60" cy="60" r="58" fill="#fff6ef"/><circle cx="60" cy="60" r="18" fill="#ec5f78"/>
                <defs><path id="sticker-path" d="M60 60 m-42 0 a42 42 0 1 1 84 0 a42 42 0 1 1 -84 0"/></defs>
                <text><textPath href="#sticker-path">TECHNIK · PROZESSE · MENSCHEN · </textPath></text>
            </svg>
        </div>

        <ul class="hero-meta reveal-fade">
            <li><?= icon('cap') ?> M.Sc. Informatik · B.Sc. Gesundheitsinformatik</li>
            <li><?= icon('globe') ?> <?= e(implode(' · ', array_map(fn($l) => $l['name'] . ' (' . $l['level'] . ')', $person['languages']))) ?></li>
        </ul>
    </section>

    <div class="ribbons" aria-hidden="true">
        <div class="ribbon ribbon-a"><div class="track">
            <?php for ($k = 0; $k < 2; $k++): foreach ($ribbonA as $s): ?><span><?= e($s) ?></span><?php endforeach; endfor; ?>
        </div></div>
        <div class="ribbon ribbon-b"><div class="track">
            <?php for ($k = 0; $k < 2; $k++): foreach ($ribbonB as $s): ?><span><?= e($s) ?></span><?php endforeach; endfor; ?>
        </div></div>
    </div>

    <!-- ============ ÜBER MICH ============ -->
    <section class="section zone" id="ueber-mich" data-bg="#fff6ef">
        <div class="container">
            <p class="kicker reveal">01 — Über mich</p>
            <p class="statement" data-words-reveal><?= e($p['about']['lead']) ?> <?= e($p['about']['paragraphs'][0]) ?></p>
            <div class="about-cols">
                <p class="reveal"><?= e($p['about']['paragraphs'][1]) ?></p>
                <blockquote class="reveal"><?= e($p['closing']) ?></blockquote>
            </div>
            <ul class="highlights">
                <?php foreach ($p['about']['highlights'] as $i => $h): ?>
                    <li class="highlight reveal" style="--delay: <?= $i * 90 ?>ms">
                        <span class="highlight-icon"><?= icon($h['icon']) ?></span>
                        <h3><?= e($h['title']) ?></h3>
                        <p><?= e($h['text']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ============ KOMPETENZEN (Horizontal-Scroll) ============ -->
    <section class="hscroll zone" id="kompetenzen" data-bg="#ffe3e8">
        <div class="hscroll-sticky">
            <div class="container hscroll-head">
                <p class="kicker">02 — Kompetenzfelder</p>
                <h2 class="h-xl">Was ich mitbringe <span class="arrow" aria-hidden="true">→</span></h2>
            </div>
            <div class="rail" id="rail">
                <?php foreach ($p['competencies'] as $i => $c): ?>
                    <article class="panel">
                        <span class="panel-blob" aria-hidden="true"></span>
                        <span class="panel-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <div>
                            <h3><?= e($c['title']) ?></h3>
                            <p><?= e($c['text']) ?></p>
                            <ul class="panel-tags">
                                <?php foreach ($c['points'] as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?>
                            </ul>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ SKILLS ============ -->
    <section class="section zone" id="skills" data-bg="#fff6ef">
        <div class="container">
            <p class="kicker reveal">03 — Werkzeuge &amp; Technologien</p>
            <h2 class="h-xl reveal">Mein Werkzeugkasten</h2>
            <p class="lead reveal"><?= (int) $skillCount ?> Werkzeuge, Methoden und Technologien – mit ehrlicher Einordnung, wie tief meine Erfahrung jeweils reicht.</p>

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
                            <span class="dots" data-level="<?= (int) $lvl ?>" aria-hidden="true"><i></i><i></i><i></i></span><?= e($label) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="skill-groups">
                <?php foreach ($p['skills'] as $cat => $items): ?>
                    <div class="skill-group reveal" data-category="<?= e(slug($cat)) ?>">
                        <h3><?= e($cat) ?></h3>
                        <ul class="skill-list">
                            <?php foreach ($items as $s): ?>
                                <li class="skill" data-level="<?= (int) $s['level'] ?>" data-name="<?= e(mb_strtolower($s['name'])) ?>" title="<?= e($p['skill_levels'][$s['level']]) ?>">
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

    <!-- ============ STATIONEN (3D-Kartenstapel) ============ -->
    <section class="section zone" id="stationen" data-bg="#fff6ef">
        <div class="container">
            <p class="kicker reveal">04 — Werdegang</p>
            <h2 class="h-xl reveal">Stationen</h2>
            <div class="stack">
                <?php foreach ($p['experience'] as $i => $job): ?>
                    <article class="stack-card">
                        <header class="stack-top">
                            <span class="stack-idx"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <?php if (!empty($job['period'])): ?><span class="stack-period"><?= e($job['period']) ?></span><?php endif; ?>
                        </header>
                        <div class="stack-main">
                            <p class="stack-role"><?= e($job['role']) ?></p>
                            <h3><?= e($job['company']) ?></h3>
                            <p class="stack-summary"><?= e($job['summary']) ?></p>
                        </div>
                        <ul class="stack-points">
                            <?php foreach ($job['points'] as $pt): ?><li><?= icon('check') ?><?= e($pt) ?></li><?php endforeach; ?>
                        </ul>
                        <ul class="pill-list">
                            <?php foreach ($job['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ AUSBILDUNG ============ -->
    <section class="section zone" id="ausbildung" data-bg="#eef3d6">
        <div class="container">
            <p class="kicker reveal">05 — Ausbildung</p>
            <h2 class="h-xl reveal">Studium</h2>
            <div class="edu-grid">
                <?php foreach ($p['education'] as $i => $edu): ?>
                    <article class="edu tilt reveal" style="--delay: <?= $i * 120 ?>ms">
                        <p class="edu-school"><?= e($edu['school']) ?></p>
                        <h3><?= e($edu['degree']) ?></h3>
                        <p class="edu-focus"><?= e($edu['focus']) ?></p>
                        <p><?= e($edu['text']) ?></p>
                        <ul class="pill-list">
                            <?php foreach ($edu['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
                <article class="edu edu-lang tilt reveal" style="--delay: 240ms">
                    <p class="edu-school">Sprachen</p>
                    <ul class="lang-list">
                        <?php foreach ($person['languages'] as $l): ?>
                            <li><span><?= e($l['name']) ?></span><strong><?= e($l['level']) ?></strong></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <!-- ============ MASTERARBEIT ============ -->
    <section class="section zone zone-dark" id="masterarbeit" data-bg="#7e0b45" data-dark>
        <div class="container">
            <p class="kicker reveal">06 — Masterarbeit</p>
            <h2 class="thesis-title reveal">„<?= e($p['thesis']['title']) ?>“</h2>
            <p class="lead reveal"><?= e($p['thesis']['text']) ?></p>
            <div class="numbers">
                <?php foreach ($p['thesis']['stats'] as $s): ?>
                    <div class="reveal"><b data-count="<?= (int) $s['value'] ?>"><?= (int) $s['value'] ?></b><?= e($s['label']) ?></div>
                <?php endforeach; ?>
            </div>
            <div class="thesis-cols">
                <div class="reveal">
                    <h3>Konzepte</h3>
                    <ul class="pill-list pill-light"><?php foreach ($p['thesis']['concepts'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
                </div>
                <div class="reveal">
                    <h3>Methodik</h3>
                    <ul class="pill-list pill-light"><?php foreach ($p['thesis']['methods'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ STÄRKEN ============ -->
    <section class="section zone" id="staerken" data-bg="#fff6ef">
        <div class="container">
            <p class="kicker reveal">07 — Arbeitsweise</p>
            <h2 class="h-xl reveal">Meine Stärken</h2>
            <ul class="strengths">
                <?php foreach ($p['strengths'] as $i => $s): ?>
                    <li class="flip reveal" style="--delay: <?= ($i % 3) * 90 ?>ms">
                        <button class="flip-inner" type="button" aria-pressed="false">
                            <span class="flip-front">
                                <span class="flip-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                <span class="flip-title"><?= e($s['title']) ?></span>
                                <span class="flip-more">Umdrehen ↻</span>
                            </span>
                            <span class="flip-back"><?= e($s['text']) ?></span>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="interests" aria-label="Fachliche Interessen">
            <p class="kicker container reveal">Was mich fachlich besonders interessiert</p>
            <div class="interest-ribbon"><div class="track">
                <?php for ($k = 0; $k < 2; $k++): foreach ($p['interests'] as $int): ?><span <?= $k ? 'aria-hidden="true"' : '' ?>><?= e($int) ?></span><?php endforeach; endfor; ?>
            </div></div>
        </div>
    </section>

    <!-- ============ KONTAKT ============ -->
    <section class="section zone zone-dark" id="kontakt" data-bg="#6e8c14" data-dark>
        <div class="container contact-grid">
            <div>
                <p class="kicker reveal">08 — Kontakt</p>
                <h2 class="big-cta reveal">Lass uns<br>sprechen.</h2>
                <p class="lead reveal">Healthcare IT, IT-Beratung, Schnittstellen, Prozessautomatisierung, UX/UI oder Produktmanagement? Ich freue mich auf deine Nachricht.</p>
                <ul class="contact-list reveal">
                    <li><?= icon('mail') ?><a href="mailto:<?= e($person['email']) ?>"><?= e($person['email']) ?></a></li>
                    <?php if (!empty($person['location'])): ?><li><?= icon('pin') ?><span><?= e($person['location']) ?></span></li><?php endif; ?>
                    <?php if (!empty($person['linkedin'])): ?><li><?= icon('linkedin') ?><a href="<?= e($person['linkedin']) ?>" rel="noopener" target="_blank">LinkedIn</a></li><?php endif; ?>
                    <?php if (!empty($person['github'])): ?><li><?= icon('github') ?><a href="<?= e($person['github']) ?>" rel="noopener" target="_blank">GitHub</a></li><?php endif; ?>
                </ul>
                <a class="magnet reveal" href="mailto:<?= e($person['email']) ?>"><span>Schreib mir <?= icon('mail') ?></span></a>
            </div>

            <form class="contact-form reveal" action="contact.php" method="post" novalidate id="contact-form">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <div class="hp" aria-hidden="true"><label>Webseite <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

                <div class="form-status <?= $flash ? ($flash['ok'] ? 'is-success' : 'is-error') : '' ?>" role="status" aria-live="polite" <?= $flash ? '' : 'hidden' ?>><?= e($flash['message'] ?? '') ?></div>

                <div class="field">
                    <label for="f-name">Name</label>
                    <input id="f-name" name="name" type="text" required minlength="2" maxlength="100" autocomplete="name" value="<?= e($old['name'] ?? '') ?>" aria-describedby="err-name">
                    <span class="field-error" id="err-name"><?= e($errors['name'] ?? '') ?></span>
                </div>
                <div class="field">
                    <label for="f-email">E-Mail</label>
                    <input id="f-email" name="email" type="email" required maxlength="200" autocomplete="email" value="<?= e($old['email'] ?? '') ?>" aria-describedby="err-email">
                    <span class="field-error" id="err-email"><?= e($errors['email'] ?? '') ?></span>
                </div>
                <div class="field">
                    <label for="f-message">Nachricht</label>
                    <textarea id="f-message" name="message" rows="5" required minlength="10" maxlength="5000" aria-describedby="err-message"><?= e($old['message'] ?? '') ?></textarea>
                    <span class="field-meta"><span class="field-error" id="err-message"><?= e($errors['message'] ?? '') ?></span><span class="char-count" id="char-count">0 / 5000</span></span>
                </div>
                <button class="btn btn-dark btn-block" type="submit"><span>Nachricht senden</span><span class="spinner" aria-hidden="true"></span></button>
            </form>
        </div>
    </section>
</main>

<footer class="site-footer">
    <p class="footer-name"><?= e($person['name']) ?>.</p>
    <div class="footer-row">
        <p>&copy; <?= date('Y') ?> · <?= e($person['role']) ?></p>
        <p class="footer-colors" aria-hidden="true"><i></i><i></i><i></i></p>
        <a href="#top">Nach oben <?= icon('arrow-up') ?></a>
    </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
