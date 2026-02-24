<?php
/**
 * Скрипт для извлечения внешних ссылок (http/https) из всех HTML-файлов в указанных папках.
 * Исключает ссылки, содержащие "r.mail.ru" или "trk.mail.ru".
 * Результат сохраняется в файл links.txt.
 *
 * Использование:
 *   php extract_links_to_file.php [папка1] [папка2] ...
 *
 * Если папки не указаны, используется текущая директория.
 */

// Получаем аргументы командной строки
if (isset($argv) && count($argv) > 1) {
    $folders = array_slice($argv, 1); // пропускаем имя скрипта
} else {
    $folders = ['../data/SMI/']; // текущая папка по умолчанию
}

$allFiles = [];

// Собираем все HTML-файлы из указанных папок (без рекурсии)
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        fwrite(STDERR, "Предупреждение: папка '$folder' не существует или не является директорией, пропускаем.\n");
        continue;
    }

    // Нормализуем путь (убираем лишние слеши) для glob
    $folder = rtrim($folder, DIRECTORY_SEPARATOR);
    $pattern = $folder . DIRECTORY_SEPARATOR . '*.html';
    $htmlFiles = glob($pattern);
    $htmFiles = glob($folder . DIRECTORY_SEPARATOR . '*.htm');
    $files = array_merge($htmlFiles, $htmFiles);

    if (!empty($files)) {
        $allFiles = array_merge($allFiles, $files);
    }
}

if (empty($allFiles)) {
    file_put_contents('links.txt', '');
    die("Не найдено HTML-файлов в указанных папках.\n");
}

$allLinks = [];
$exclude = ['r.mail.ru', 'trk.mail.ru'];

foreach ($allFiles as $filename) {
    $html = file_get_contents($filename);
    if ($html === false) {
        fwrite(STDERR, "Предупреждение: не удалось прочитать файл '$filename', пропускаем.\n");
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
    $allLinks = array_merge($allLinks, $fileLinks);
}

// Глобальная обработка
$allLinks = array_unique($allLinks);
sort($allLinks);

// Сохраняем в файл
$outputFile = '../data/SMI/links.txt';
if (file_put_contents($outputFile, implode("\n", $allLinks)) !== false) {
    echo "Готово! Найдено ссылок: " . count($allLinks) . ". Результат сохранён в файл '$outputFile'.\n";
} else {
    echo "Ошибка при записи в файл '$outputFile'.\n";
}