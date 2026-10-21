# Persönliche Profil-Webseite

Responsive, interaktive Profilseite mit **PHP**, **HTML**, **CSS** und **JavaScript** (ohne Frameworks oder Build-Schritt).

## Design: „Kinetic Editorial“

Helles, mutiges Editorial-Layout mit satten Farbflächen, großer Typografie und Motion-Design.

| Rolle | Farbe |
|---|---|
| Akzent, Kontakt-Zone | `#6E8C14` (Oliv, satt) |
| Highlights, Bewegung | `#EC5F78` (Rosé, satt) |
| Überschriften, Masterarbeit-Zone | `#7E0B45` (Beere, satt) |
| Fließtext | `#1C0F15` (Anthrazit) · Grundfläche `#FFF6EF` (Creme) |

## Funktionen

- Hero mit aufsteigender Riesentypografie, Schreibmaschinen-Rollen und **Bild-Platzhalter** in gestaffelten Bögen, die der Maus folgen (Parallaxe)
- Schräge 3D-Laufbänder mit Skills und Interessen
- Hintergrundfarbe wechselt fließend je Sektion (Farbzonen)
- „Über mich“: Wörter leuchten beim Scrollen nacheinander auf
- Kompetenzfelder als horizontale Scroll-Strecke (auf dem Handy: Wischen)
- Stationen als 3D-Kartenstapel, der beim Scrollen nach hinten kippt
- Ausbildung mit 3D-Tilt, Masterarbeit mit hochzählenden Kennzahlen
- Stärken als 3D-Flip-Karten (Hover, Tippen oder Tastatur)
- Skill-Übersicht mit Suche, Kategorie- und Erfahrungsstufen-Filter
- Eigener Cursor, magnetische Buttons, Scroll-Fortschritt, Vollbild-Menü auf dem Handy
- Kontaktformular mit Client- und Servervalidierung, CSRF-Schutz, Honeypot und Rate-Limit
- Barrierearm: Tastaturbedienung, `prefers-reduced-motion` schaltet alle Bewegungen ab, funktioniert auch ohne JavaScript, druckfreundlich

Die drei ursprünglichen Designentwürfe liegen zum Vergleich in `design-vorschlaege/`.

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

## Veröffentlichen mit Firebase Hosting

Firebase Hosting führt kein PHP aus. `build.php` erzeugt deshalb eine statische Version der Seite in `public/`.
Bei `firebase deploy` passiert das automatisch (siehe `firebase.json`).

### Einmalig einrichten

1. Projekt anlegen auf <https://console.firebase.google.com> („Projekt hinzufügen“, Google Analytics kann aus bleiben).
2. [Node.js](https://nodejs.org) (LTS) installieren, dann im Terminal:
   ```bash
   npm install -g firebase-tools
   firebase login
   firebase use --add        # Projekt auswählen, Alias z. B. "default"
   ```
   **Nicht** `firebase init` ausführen – die Konfiguration (`firebase.json`) ist schon fertig.

### Kontaktformular

- Kostenlosen Access Key bei <https://web3forms.com> holen (E-Mail-Adresse eingeben, Key kommt per Mail).
- Key in `includes/config.php` bei `web3forms_key` eintragen.
- Ohne Key öffnet das Formular stattdessen das E-Mail-Programm der Besucher mit vorausgefüllter Nachricht.

### Deployen

```bash
firebase deploy --only hosting
```

Die Seite ist danach unter `https://<projekt-id>.web.app` erreichbar. Eine eigene Domain lässt sich in der
Firebase-Konsole unter *Hosting → Benutzerdefinierte Domain hinzufügen* verbinden.

Vorab lokal ansehen: `php build.php` und dann `firebase serve --only hosting` (oder `public/index.html` im Browser öffnen).
