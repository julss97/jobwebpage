<?php
/**
 * Verarbeitet das Kontaktformular.
 *
 * Antwortet mit JSON, wenn die Anfrage per JavaScript (fetch) kommt,
 * sonst mit einer Weiterleitung zurück zur Startseite (funktioniert also auch ohne JS).
 */

declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
$config = require __DIR__ . '/includes/config.php';

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

function respond(bool $ok, string $message, array $errors, bool $json): never
{
    if ($json) {
        http_response_code($ok ? 200 : 422);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message, 'errors' => $errors], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $_SESSION['contact_flash'] = ['ok' => $ok, 'message' => $message, 'errors' => $errors, 'old' => $ok ? [] : $_POST];
    header('Location: index.php#kontakt', true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: index.php#kontakt', true, 303);
    exit;
}

if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    respond(false, 'Die Sitzung ist abgelaufen. Bitte lade die Seite neu und versuche es erneut.', [], $wantsJson);
}

// Honeypot: Dieses Feld ist für Menschen unsichtbar. Ist es ausgefüllt, war es vermutlich ein Bot.
if (!empty($_POST['website'])) {
    respond(true, 'Vielen Dank für deine Nachricht!', [], $wantsJson);
}

$last = $_SESSION['contact_last_sent'] ?? 0;
if (time() - $last < $config['rate_limit_secs']) {
    respond(false, 'Bitte warte einen Moment, bevor du eine weitere Nachricht sendest.', [], $wantsJson);
}

$name    = trim((string) ($_POST['name'] ?? ''));
$email   = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

$errors = [];
if (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
    $errors['name'] = 'Bitte gib deinen Namen an (2–100 Zeichen).';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Bitte gib eine gültige E-Mail-Adresse an.';
}
if (mb_strlen($message) < 10 || mb_strlen($message) > 5000) {
    $errors['message'] = 'Die Nachricht sollte zwischen 10 und 5000 Zeichen lang sein.';
}
if ($errors) {
    respond(false, 'Bitte überprüfe deine Eingaben.', $errors, $wantsJson);
}

// Zeilenumbrüche aus Header-Werten entfernen (Schutz vor Header-Injection).
$safeName  = str_replace(["\r", "\n"], ' ', $name);
$safeEmail = str_replace(["\r", "\n"], '', $email);

$subject = '=?UTF-8?B?' . base64_encode('Neue Nachricht über die Webseite von ' . $safeName) . '?=';
$body    = "Name: {$safeName}\nE-Mail: {$safeEmail}\n\n{$message}\n";
$headers = implode("\r\n", [
    'From: ' . $config['contact_from'],
    'Reply-To: ' . $safeEmail,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . PHP_VERSION,
]);

$stored = false;
if ($config['store_messages']) {
    $dir = dirname($config['messages_file']);
    if (is_dir($dir) || @mkdir($dir, 0750, true)) {
        $entry  = '[' . date('c') . "]\n" . $body . str_repeat('-', 40) . "\n";
        $stored = @file_put_contents($config['messages_file'], $entry, FILE_APPEND | LOCK_EX) !== false;
    }
}
$sent = @mail($config['contact_to'], $subject, $body, $headers);

if (!$sent && !$stored) {
    respond(false, 'Die Nachricht konnte leider nicht zugestellt werden. Bitte schreibe mir direkt per E-Mail.', [], $wantsJson);
}

$_SESSION['contact_last_sent'] = time();
respond(true, 'Vielen Dank, ' . $safeName . '! Deine Nachricht ist angekommen – ich melde mich bald.', [], $wantsJson);
