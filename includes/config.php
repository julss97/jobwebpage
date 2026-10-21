<?php
/**
 * Technische Einstellungen.
 */

return [
    // Empfängeradresse für das Kontaktformular.
    'contact_to'      => 'kontakt@example.de',
    // Absenderadresse (muss meist zur Domain des Servers passen).
    'contact_from'    => 'webseite@example.de',
    // Nachrichten zusätzlich in eine Datei schreiben (praktisch, wenn mail() lokal nicht konfiguriert ist).
    'store_messages'  => true,
    'messages_file'   => __DIR__ . '/../storage/messages.log',
    // Mindestabstand zwischen zwei Nachrichten pro Sitzung (Sekunden).
    'rate_limit_secs' => 60,
];
