<?php
/**
 * Inhalte der Webseite.
 *
 * Alle Texte stehen zentral in dieser Datei, damit sie ohne Eingriff in
 * HTML, CSS oder JavaScript angepasst werden können.
 */

return [
    'meta' => [
        'title'       => 'Julia Betz – Informatikerin | Healthcare IT, Daten & digitale Produkte',
        'description' => 'Informatikerin mit Hintergrund in Gesundheitsinformatik und IT-Management: '
                       . 'Softwareentwicklung, Schnittstellen, Data Science, KI und nutzerorientierte Produktgestaltung.',
    ],

    'person' => [
        'name'      => 'Julia Betz',
        'role'      => 'Informatikerin',
        // Pfad zum eigenen Foto, z. B. 'assets/img/profil.jpg'. Leer lassen = Platzhalter.
        'photo'     => 'assets\img\selfie.jpeg',
        'email'     => 'julia.betz97@outlook.de',
        'location'  => 'Region Konstanz',
        'linkedin'  => 'www.linkedin.com/in/juliabetz1997',
        'github'    => 'www.github.com/julss97',
        'languages' => [
            ['name' => 'Deutsch',  'level' => 'Muttersprache'],
            ['name' => 'Englisch', 'level' => 'B2'],
        ],
    ],

    'hero' => [
        'greeting' => 'Hallo, ich bin',
        'rotating' => [
            'Informatikerin',
            'Brückenbauerin zwischen Technik & Fachbereich',
            'Healthcare-IT-Enthusiastin',
            'Problemlöserin mit Daten & KI',
        ],
        'claim'    => 'Ich verbinde Technologie, Prozesse und Menschen und nutze Software, '
                    . 'Daten und KI, um Arbeitsabläufe zu verbessern und den Alltag von Menschen zu erleichtern.',
    ],

    'about' => [
        'lead' => 'Informatikerin mit interdisziplinärem Hintergrund in Gesundheitsinformatik und IT-Management.',
        'paragraphs' => [
            'Mich interessiert besonders, wie sich Technologie sinnvoll einsetzen lässt, um Arbeitsabläufe zu verbessern, '
            . 'komplexe Probleme zu lösen und den Alltag von Menschen zu erleichtern. Ich bewege mich gerne an der '
            . 'Schnittstelle zwischen Technik, fachlichen Anforderungen und menschlichen Bedürfnissen.',
            'Ich möchte nicht einfach nur technische Funktionen umsetzen, sondern zuerst verstehen, welches Problem gelöst '
            . 'werden soll, welche Anforderungen die Beteiligten haben und wie daraus eine praktikable, verständliche und '
            . 'nutzerorientierte Lösung entsteht.',
        ],
        'highlights' => [
            ['icon' => 'heart',  'title' => 'Healthcare IT',        'text' => 'Schnittstellen, FHIR & digitale Prozesse im Gesundheitswesen'],
            ['icon' => 'code',   'title' => 'Softwareentwicklung',  'text' => 'Java, C#, Python, SQL – praxisorientiert und lösungsfokussiert'],
            ['icon' => 'spark',  'title' => 'Daten & KI',           'text' => 'Data Science, Machine Learning, NLP und generative KI'],
            ['icon' => 'users',  'title' => 'Mensch im Mittelpunkt', 'text' => 'Requirements Engineering, UX/UI und klare Kommunikation'],
        ],
    ],

    'education' => [
        [
            'degree'  => 'Master of Science Informatik',
            'focus'   => 'Schwerpunkt IT-Management',
            'school'  => 'Hochschule Konstanz (HTWG)',
            'text'    => 'Vertiefung technischer Kenntnisse, erweitert um betriebswirtschaftliche, analytische und organisatorische '
                       . 'Perspektiven mit Fokus auf Datenanalyse, KI, Produktentwicklung und IT-Management.',
            'tags'    => ['Data Science', 'Machine Learning', 'NLP', 'IT-Management', 'Produktentwicklung'],
        ],
        [
            'degree'  => 'Bachelor of Science Gesundheitsinformatik',
            'focus'   => 'Informatik trifft Medizin',
            'school'  => 'Hochschule Konstanz (HTWG)',
            'text'    => 'Grundlagen der Informatik verbunden mit medizinischen Anwendungsfeldern: sensible Daten, Zusammenarbeit '
                       . 'verschiedener Berufsgruppen, Integration heterogener Systeme und zuverlässige digitale Prozesse.',
            'tags'    => ['Informatik-Grundlagen', 'Healthcare IT', 'Datenschutz', 'Systemintegration'],
        ],
    ],

    'thesis' => [
        'title'    => 'Personalisiertes Lernen durch KI-gestützte sprachliche Interaktion',
        'text'     => 'Wie können KI-basierte Systeme personalisierte Lernprozesse durch sprachliche Interaktion unterstützen – '
                    . 'ohne Lernenden das eigenständige Denken abzunehmen? Aus Theorie und Praxis habe ich ein konzeptionelles '
                    . 'Modell für KI-gestützte, personalisierte Lerninteraktionen abgeleitet.',
        'concepts' => ['Scaffolding', 'Zone der nächsten Entwicklung', 'Feedback', 'Sokratische Fragen', 'Dialogische Interaktion'],
        'methods'  => ['Literaturrecherche', 'Design Science', 'Experteninterviews', 'Qualitative Inhaltsanalyse nach Mayring'],
        'stats'    => [
            ['value' => 8,  'label' => 'Experteninterviews'],
            ['value' => 13, 'label' => 'untersuchte Systeme'],
            ['value' => 26, 'label' => 'Bewertungskriterien'],
        ],
    ],

    'experience' => [
        [
            'company' => 'Dedalus HealthCare',
            'role'    => 'Software- & Schnittstellenentwicklung im Gesundheitswesen',
            'period'  => '', // optional, z. B. '2023 – 2024'
            'summary' => 'Entwicklung und Integration von Softwarelösungen für das Gesundheitswesen.',
            'points'  => [
                'Arbeit mit Java, REST-APIs und HL7 FHIR',
                'Untersuchung von API-Requests, -Responses und HTTP-Statuscodes mit Postman',
                'Datenbankabfragen mit SQL, Versionsverwaltung mit Git',
                'Tests, technische Dokumentation und Abstimmung mit anderen Beteiligten',
            ],
            'tags'    => ['Java', 'REST', 'FHIR', 'SQL', 'Postman', 'Git'],
        ],
        [
            'company' => 'Pfizer Manufacturing',
            'role'    => 'Digitalisierung & Automatisierung von Arbeitsabläufen',
            'period'  => '',
            'summary' => 'Verbesserung bestehender Prozesse durch Software und Datenbanken.',
            'points'  => [
                'Anforderungen aufgenommen und mit Beteiligten abgestimmt',
                'Prozesse analysiert und technische Lösungen mitentwickelt',
                'Bestehende Anwendungen angepasst und wiederkehrende Aufgaben automatisiert',
                'Arbeit mit Datenbanken zur Reduzierung manueller Tätigkeiten',
            ],
            'tags'    => ['C#', 'VBA', 'MS Access', 'SQL', 'Prozessanalyse'],
        ],
        [
            'company' => 'Siemens Logistics',
            'role'    => 'Second-Level-IT-Support',
            'period'  => '',
            'summary' => 'Analyse und Bearbeitung technischer Probleme sowie Unterstützung von Anwenderinnen und Anwendern.',
            'points'  => [
                'Systematische Fehleranalyse: Hardware, Drucker, Dockingstations, Windows-Systeme',
                'Support per Telefon, E-Mail und Remote-Zugriff',
                'Ticketbearbeitung mit Priorisierung und nachvollziehbarer Dokumentation',
                'Technische Sachverhalte verständlich erklärt',
            ],
            'tags'    => ['Windows', 'Remote-Support', 'Ticketsysteme', 'Fehleranalyse'],
        ],
        [
            'company' => 'Pandora',
            'role'    => 'Verkauf & Kundenberatung',
            'period'  => '',
            'summary' => 'Direkter Kundenkontakt mit Fokus auf Bedarfsermittlung und Service.',
            'points'  => [
                'Bedürfnisse erkennen und passende Lösungen nachvollziehbar erklären',
                'Serviceorientierter Umgang mit unterschiedlichsten Menschen',
            ],
            'tags'    => ['Kommunikation', 'Bedarfsanalyse', 'Service'],
        ],
        [
            'company' => 'Hochschule Konstanz',
            'role'    => 'Gremien- & Vertretungsarbeit',
            'period'  => '',
            'summary' => 'Engagement in Fachschaft und Studienkommission.',
            'points'  => [
                'Einblicke in Abstimmungsprozesse und unterschiedliche Interessen',
                'Zusammenarbeit in Gruppen und gemeinsame Lösungsfindung',
            ],
            'tags'    => ['Teamarbeit', 'Stakeholder', 'Engagement'],
        ],
    ],

    // Kompetenzfelder für das interaktive Akkordeon/Tab-Modul
    'competencies' => [
        [
            'id'    => 'healthcare',
            'title' => 'Healthcare IT & Schnittstellen',
            'text'  => 'Ich kenne die Verbindung zwischen medizinischen bzw. administrativen Abläufen und den IT-Systemen, die sie '
                     . 'unterstützen – von Krankenhausinformationssystemen über DMS/ECM bis zu strukturierten Gesundheitsdaten.',
            'points'=> ['REST-APIs & HL7 FHIR', 'Datenflüsse zwischen heterogenen Systemen', 'Datenschutz & Zuverlässigkeit', 'KIS, DMS & ECM-Systeme'],
        ],
        [
            'id'    => 'data',
            'title' => 'Daten, Data Science & KI',
            'text'  => 'Von relationalen Datenbanken über explorative Analyse bis zu Machine Learning: Mich interessiert, welche '
                     . 'Erkenntnisse sich aus Daten gewinnen lassen – und wo die Grenzen einer Analyse liegen.',
            'points'=> ['Regression, Klassifikation, Clustering', 'PCA & t-SNE', 'Natural Language Processing', 'Generative KI & LLMs'],
        ],
        [
            'id'    => 'process',
            'title' => 'Prozesse & Automatisierung',
            'text'  => 'Ich erkenne Medienbrüche, manuelle Tätigkeiten und unnötige Komplexität. Automatisierung ist für mich dann '
                     . 'sinnvoll, wenn sie ein echtes Problem löst und den Menschen einen Mehrwert bietet.',
            'points'=> ['Prozessanalyse', 'Workflow-Automatisierung', 'Digitale Prozessgestaltung', 'Systemintegration'],
        ],
        [
            'id'    => 'requirements',
            'title' => 'Requirements Engineering',
            'text'  => 'Aus einer unübersichtlichen Fragestellung ein strukturiertes Bild entwickeln: Was soll erreicht werden? Wer '
                     . 'ist beteiligt? Welche Einschränkungen gibt es? Und woran erkennt man, dass eine Lösung funktioniert?',
            'points'=> ['Anforderungen aufnehmen & strukturieren', 'User Stories', 'Stakeholder-Abstimmung', 'Bedarf vs. Lösungsvorschlag unterscheiden'],
        ],
        [
            'id'    => 'ux',
            'title' => 'UX/UI & Produktgestaltung',
            'text'  => 'Mich interessiert, wie Menschen Software erleben. Designentscheidungen begründe ich mit Aufgaben, Bedürfnissen '
                     . 'und Nutzungssituationen der Zielgruppe – nicht mit persönlichem Geschmack.',
            'points'=> ['Figma & Wireframes', 'Personas', 'Prototyping', 'Usability'],
        ],
        [
            'id'    => 'support',
            'title' => 'Support & Dokumentation',
            'text'  => 'Fehler systematisch eingrenzen, Ursachen statt Symptome beheben und Wissen so dokumentieren, dass andere '
                     . 'daran anknüpfen können.',
            'points'=> ['Strukturierte Fehleranalyse', 'Ticketsysteme', 'Technische Dokumentation', 'Wissensmanagement'],
        ],
    ],

    /*
     * Werkzeuge & Technologien.
     * level: 3 = praktisch im Berufsalltag eingesetzt, 2 = im Studium/Projekten vertieft, 1 = Grundlagen/erste Erfahrungen
     */
    'skill_levels' => [
        3 => 'Praxiserfahrung',
        2 => 'Studium & Projekte',
        1 => 'Grundlagen',
    ],
    'skills' => [
        'Programmierung' => [
            ['name' => 'Java',        'level' => 3],
            ['name' => 'C#',          'level' => 3],
            ['name' => 'Python',      'level' => 2],
            ['name' => 'VBA',         'level' => 3],
            ['name' => 'SQL',         'level' => 3],
            ['name' => 'HTML & CSS',  'level' => 2],
            ['name' => 'JavaScript',  'level' => 1],
            ['name' => 'PHP',         'level' => 1],
        ],
        'Daten & Datenbanken' => [
            ['name' => 'Relationale Datenbanken', 'level' => 3],
            ['name' => 'Microsoft Access',        'level' => 3],
            ['name' => 'Datenabfragen',           'level' => 3],
            ['name' => 'MySQL',                   'level' => 1],
        ],
        'APIs & Integration' => [
            ['name' => 'REST-APIs',          'level' => 3],
            ['name' => 'HL7 FHIR',           'level' => 3],
            ['name' => 'Postman',            'level' => 3],
            ['name' => 'HTTP-Statuscodes',   'level' => 3],
            ['name' => 'Technische Datenflüsse', 'level' => 2],
        ],
        'Data Science & ML' => [
            ['name' => 'pandas',              'level' => 2],
            ['name' => 'scikit-learn',        'level' => 2],
            ['name' => 'Statistische Analyse', 'level' => 2],
            ['name' => 'Regression & Klassifikation', 'level' => 2],
            ['name' => 'Clustering',          'level' => 2],
            ['name' => 'PCA & t-SNE',         'level' => 2],
            ['name' => 'NLP',                 'level' => 2],
        ],
        'Entwicklung & Zusammenarbeit' => [
            ['name' => 'Git & GitHub',              'level' => 3],
            ['name' => 'Softwaretests',             'level' => 3],
            ['name' => 'Technische Dokumentation',  'level' => 3],
        ],
        'UX/UI & Produkt' => [
            ['name' => 'Figma',        'level' => 2],
            ['name' => 'Wireframes',   'level' => 2],
            ['name' => 'Personas',     'level' => 2],
            ['name' => 'User Stories', 'level' => 2],
            ['name' => 'Prototyping',  'level' => 2],
            ['name' => 'Usability',    'level' => 2],
        ],
        'Projekt & Prozess' => [
            ['name' => 'Requirements Engineering', 'level' => 3],
            ['name' => 'Prozessanalyse',           'level' => 3],
            ['name' => 'Stakeholder-Abstimmung',   'level' => 3],
            ['name' => 'Jira',                     'level' => 2],
            ['name' => 'Trello',                   'level' => 2],
            ['name' => 'Miro',                     'level' => 2],
            ['name' => 'Scrum-Grundlagen',         'level' => 1],
        ],
        'KI-Werkzeuge' => [
            ['name' => 'ChatGPT',        'level' => 3],
            ['name' => 'Claude',         'level' => 3],
            ['name' => 'GitHub Copilot', 'level' => 2],
            ['name' => 'LLMs & generative KI', 'level' => 2],
        ],
        'IT-Betrieb & Support' => [
            ['name' => 'Windows-Systeme',  'level' => 3],
            ['name' => 'Remote-Support',   'level' => 3],
            ['name' => 'Ticketsysteme',    'level' => 3],
            ['name' => 'Fehleranalyse',    'level' => 3],
            ['name' => 'Linux',            'level' => 1],
            ['name' => 'Docker',           'level' => 1],
            ['name' => 'PowerShell',       'level' => 1],
        ],
    ],

    'strengths' => [
        ['title' => 'Analytisch & strukturiert', 'text' => 'Erst die Ausgangssituation verstehen, dann strukturieren, recherchieren und Lösungswege entwickeln.'],
        ['title' => 'Lernfreudig & vielseitig',  'text' => 'Schnelle Einarbeitung in neue Themen – von Softwareentwicklung über Produktion bis Kundenkontakt.'],
        ['title' => 'Verständlich kommunizieren', 'text' => 'Komplexes in Schritte zerlegen und so aufbereiten, dass andere es nachvollziehen können.'],
        ['title' => 'Offen für bessere Wege',    'text' => 'Ich halte nicht an einer Lösung fest, nur weil sie schon vorgeschlagen wurde – ich prüfe Annahmen.'],
        ['title' => 'Genau & nachvollziehbar',   'text' => 'Ich lege Wert auf Genauigkeit, nachvollziehbare Ergebnisse und offene Kommunikation.'],
        ['title' => 'Teamplayerin',              'text' => 'Unterschiedliche Sichtweisen sind für mich eine Chance, bessere Lösungen zu finden.'],
    ],

    'interests' => [
        'Healthcare IT', 'IT-Beratung', 'Daten- & Schnittstellenintegration', 'Prozessautomatisierung',
        'UX/UI', 'Produktmanagement', 'Verantwortungsvolle KI', 'Anwendungsbetreuung', 'Datenmigration',
    ],

    'closing' => 'Ich möchte Technologie nicht um ihrer selbst willen einsetzen, sondern sie nutzen, um Probleme verständlich '
               . 'zu machen, Arbeitsabläufe zu verbessern und Menschen bei ihren Aufgaben zu unterstützen.',
];
