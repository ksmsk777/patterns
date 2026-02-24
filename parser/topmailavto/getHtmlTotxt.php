<?php
/**
 * Скрипт для извлечения внешних ссылок (http/https) из всех HTML-файлов в текущей папке.
 * Исключает ссылки, содержащие "r.mail.ru" или "trk.mail.ru".
 * Результат сохраняется в файл links.txt.
 * Использование: php extract_links_to_file.php
 */

// Находим все HTML-файлы в текущей директории
$files = glob("*.html");
$files = array_merge($files, glob("*.htm")); // добавляем .htm, если нужны

if (empty($files)) {
    file_put_contents('links.txt', '');
    die("В текущей папке не найдено HTML-файлов.\n");
}

$allLinks = [];
$exclude = ['r.mail.ru', 'trk.mail.ru'];

foreach ($files as $filename) {
    $html = file_get_contents($filename);
    if ($html === false) {
        continue; // молча пропускаем проблемные файлы
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
    libxml_clear_errors();

    $anchors = $dom->getElementsByTagName('a');
    $fileLinks = [];

    foreach ($anchors as $anchor) {
        $href = $anchor->getAttribute('href');
        // Проверяем, что ссылка начинается с http:// или https://
        if (!empty($href) && (strpos($href, 'http://') === 0 || strpos($href, 'https://') === 0)) {
            // Проверяем исключения
            $excluded = false;
            foreach ($exclude as $pattern) {
                if (strpos($href, $pattern) !== false) {
                    $excluded = true;
                    break;
                }
            }
            if (!$excluded) {
                $fileLinks[] = $href;
            }
        }
    }

    $fileLinks = array_unique($fileLinks);
    $allLinks = array_merge($allLinks, $fileLinks);
}

// Глобальная обработка
$allLinks = array_unique($allLinks);
sort($allLinks);

// Сохраняем в файл
$outputFile = 'links.txt';
if (file_put_contents($outputFile, implode("\n", $allLinks)) !== false) {
    echo "Готово! Найдено ссылок: " . count($allLinks) . ". Результат сохранён в файл '$outputFile'.\n";
} else {
    echo "Ошибка при записи в файл '$outputFile'.\n";
}