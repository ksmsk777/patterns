<?php
/**
 * Скрипт для извлечения внешних ссылок (http/https) из всех HTML-файлов в текущей папке.
 * Исключает ссылки, содержащие "r.mail.ru" или "trk.mail.ru".
 * Использование: php extract_links_from_all.php
 */

// Находим все HTML-файлы в текущей директории
$files = glob("*.html");
$files = array_merge($files, glob("*.htm")); // добавляем .htm, если нужны

if (empty($files)) {
    die("В текущей папке не найдено HTML-файлов.\n");
}

$allLinks = [];
$exclude = ['r.mail.ru', 'trk.mail.ru'];

foreach ($files as $filename) {
    echo "Обрабатывается: $filename\n";
    
    $html = file_get_contents($filename);
    if ($html === false) {
        echo "  Ошибка чтения файла, пропускаем.\n";
        continue;
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
    echo "  Найдено уникальных ссылок в файле: " . count($fileLinks) . "\n";
    
    // Добавляем в общий массив
    $allLinks = array_merge($allLinks, $fileLinks);
}

// Глобальная обработка
$allLinks = array_unique($allLinks);
sort($allLinks);

echo "\n===== РЕЗУЛЬТАТ =====\n";
if (empty($allLinks)) {
    echo "Внешних ссылок (без исключений) не найдено.\n";
} else {
    echo "Всего уникальных ссылок из всех файлов: " . count($allLinks) . "\n";
    foreach ($allLinks as $link) {
        echo $link . "\n";
    }
}