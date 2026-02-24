<?php
/**
 * Скрипт для извлечения внешних ссылок (http/https) из HTML-файла,
 * исключая нежелательные домены/подстроки.
 * Использование: php extract_links.php <имя_файла.html>
 */

if ($argc < 2) {
    die("Укажите имя HTML-файла: php extract_links.php файл.html\n");
}
$filename = $argv[1];

if (!file_exists($filename)) {
    die("Файл '$filename' не найден.\n");
}

$html = file_get_contents($filename);
if ($html === false) {
    die("Ошибка при чтении файла.\n");
}

libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
libxml_clear_errors();

$anchors = $dom->getElementsByTagName('a');
$links = [];

// Список подстрок, которые нужно исключить
$exclude = ['r.mail.ru', 'trk.mail.ru'];

foreach ($anchors as $anchor) {
    $href = $anchor->getAttribute('href');
    // Проверяем, что ссылка начинается с http:// или https://
    if (!empty($href) && (strpos($href, 'http://') === 0 || strpos($href, 'https://') === 0)) {
        // Проверяем, не содержит ли ссылка исключаемые подстроки
        $excluded = false;
        foreach ($exclude as $pattern) {
            if (strpos($href, $pattern) !== false) {
                $excluded = true;
                break;
            }
        }
        if (!$excluded) {
            $links[] = $href;
        }
    }
}

$links = array_unique($links);
sort($links);

if (empty($links)) {
    echo "Внешних ссылок (без исключений) не найдено.\n";
} else {
    echo "Найдено внешних ссылок: " . count($links) . "\n";
    foreach ($links as $link) {
        echo $link . "\n";
    }
}