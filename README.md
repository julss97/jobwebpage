# Persönliche Profil-Webseite

Responsive, interaktive Profilseite mit **PHP**, **HTML**, **CSS** und **JavaScript** (ohne Frameworks oder Build-Schritt).

## Farbpalette

| Rolle | Farbe |
|---|---|
| Akzent / Buttons | `#667436` (Olive) |
| Highlights / Dekoration | `#D9828D` (Rosé) |
| Überschriften / Kontrastflächen | `#621E3E` (Beere) |
| Fließtext | `#2B2227` (warmes Anthrazit) |

Im Dunkelmodus werden helle Varianten derselben Farben verwendet.

## Funktionen

- Hero mit Schreibmaschinen-Effekt und **Platzhalter für ein Porträtfoto**
- Navigation mit Scroll-Fortschritt, aktivem Abschnitt und mobilem Menü
- Hell-/Dunkelmodus (merkt sich die Auswahl)
- Kompetenzfelder als barrierearme Tabs (Pfeiltasten-Steuerung)
- Skill-Übersicht mit Suche, Kategorie- und Erfahrungsstufen-Filter
- Aufklappbare Timeline der beruflichen Stationen
- Masterarbeit mit animierten Kennzahlen
- Flip-Karten für Stärken (Hover, Klick oder Tastatur)
- Kontaktformular mit Client- und Servervalidierung, CSRF-Schutz, Honeypot und Rate-Limit
- Respektiert `prefers-reduced-motion`, druckfreundliches Layout

## Struktur

```
index.php              Seite (Template)
contact.php            Verarbeitung des Kontaktformulars (JSON oder Redirect)
data/profile.php       ALLE Inhalte – hier Texte anpassen
includes/config.php    E-Mail-Empfänger & Formular-Einstellungen
includes/functions.php Hilfsfunktionen (Escaping, CSRF, Icons)
assets/css/style.css   Gestaltung & Responsive Layout
assets/js/main.js      Interaktionen
assets/img/            Bilder (Foto hier ablegen)
```

## Lokal starten

```bash
php -S localhost:8000
```

Dann <http://localhost:8000> öffnen. Benötigt PHP 8.0+.

## Anpassen

- **Foto einfügen:** Bild z. B. als `assets/img/profil.jpg` ablegen und in `data/profile.php` bei `person.photo` den Pfad eintragen. Ohne Pfad erscheint der Platzhalter.
- **Kontaktdaten:** `person.email`, `linkedin`, `github` in `data/profile.php` sowie `contact_to` / `contact_from` in `includes/config.php` setzen.
- **Zeiträume:** Bei den Stationen kann optional `period` (z. B. `'2023 – 2024'`) ergänzt werden.
- **Skills:** `level` 3 = Praxiserfahrung, 2 = Studium & Projekte, 1 = Grundlagen.

Nachrichten aus dem Formular werden per `mail()` versendet und zusätzlich in `storage/messages.log` gespeichert (abschaltbar über `store_messages`). Der Ordner `storage/` ist in `.gitignore` und sollte auf dem Server nicht öffentlich erreichbar sein.
