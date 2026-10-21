<?php
/**
 * Erzeugt eine statische Version der Website im Ordner public/ – z. B. für Firebase Hosting,
 * das kein PHP ausführen kann.
 *
 * Aufruf:  php build.php
 * (wird bei "firebase deploy" automatisch ausgeführt, siehe firebase.json)
 */

declare(strict_types=1);

define('STATIC_BUILD', true);

$root = __DIR__;
$out  = $root . '/public';

/** Ordner rekursiv löschen. */
function remove_dir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($items as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($dir);
}

/** Ordner rekursiv kopieren. */
function copy_dir(string $from, string $to): int
{
    $count = 0;
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($items as $item) {
        $target = $to . DIRECTORY_SEPARATOR . $items->getSubPathname();
        if ($item->isDir()) {
            is_dir($target) || mkdir($target, 0755, true);
        } else {
            copy($item->getPathname(), $target);
            $count++;
        }
    }
    return $count;
}

remove_dir($out);
mkdir($out . '/assets', 0755, true);

// Seite rendern
ob_start();
require $root . '/index.php';
$html = (string) ob_get_clean();
file_put_contents($out . '/index.html', $html);

// Nur die Assets kopieren, die die Seite tatsächlich braucht
$files = 0;
foreach (['css', 'js', 'img'] as $dir) {
    if (is_dir("$root/assets/$dir")) {
        mkdir("$out/assets/$dir", 0755, true);
        $files += copy_dir("$root/assets/$dir", "$out/assets/$dir");
    }
}

$config = require $root . '/includes/config.php';
$mode   = $config['web3forms_key'] !== '' ? 'Web3Forms' : 'E-Mail-Link (kein web3forms_key gesetzt)';

fwrite(STDOUT, sprintf(
    "Statische Website erstellt: public/index.html (%s KB) + %d Asset-Dateien\nKontaktformular: %s\n",
    number_format(strlen($html) / 1024, 1),
    $files,
    $mode
));
