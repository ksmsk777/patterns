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

$folder_name = '../data/';
$outputFile = $folder_name;



// Получаем аргументы командной строки
if (isset($argv) && count($argv) > 1) {
    $folders = array_slice($argv, 1); // пропускаем имя скрипта
} else {
    $folders = [$folder_name]; // текущая папка по умолчанию
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

// Сохраняем в файл с проверкой на уникальность
$outputFile = $folder_name . 'links.txt';
$newLinks = $allLinks;

// Убираем возможные дубликаты внутри самого массива новых ссылок
$newLinks = array_unique($newLinks);

// Читаем существующие ссылки из файла (если файл существует)
$existingLinks = [];
if (file_exists($outputFile)) {
    $fileContent = file($outputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($fileContent !== false) {
        $existingLinks = $fileContent;
    }
}

// Оставляем только те ссылки, которых ещё нет в файле
$linksToAdd = array_diff($newLinks, $existingLinks);

if (empty($linksToAdd)) {
    echo "Новых уникальных ссылок не найдено. Файл '$outputFile' остался без изменений.\n";
} else {
    // Добавляем новые ссылки в конец файла
    $content = implode("\n", $linksToAdd) . "\n";
    if (file_put_contents($outputFile, $content, FILE_APPEND | LOCK_EX) !== false) {
        echo "Готово! Добавлено новых уникальных ссылок: " . count($linksToAdd) . ". Результат добавлен в файл '$outputFile'.\n";
    } else {
        echo "Ошибка при добавлении в файл '$outputFile'.\n";
    }
}


/////////////////////////// 
// Теперь удалим все html файлы из папки

// Укажите путь к папке, в которой нужно удалить файлы
$folder = $folder_name; // например, папка 'files' в текущей директории

// Проверяем, существует ли папка
if (!is_dir($folder)) {
    die("Ошибка: Папка '$folder' не найдена.");
}

// Получаем список всех файлов .html и .htm
$files = glob($folder . '/*.{html,htm}', GLOB_BRACE);

if (empty($files)) {
    echo "Файлы с расширениями .html и .htm не найдены.";
    exit;
}

// Выводим список файлов, которые будут удалены (для проверки)
echo "Будут удалены следующие файлы:\n";
foreach ($files as $file) {
    echo $file . "\n";
}

// Запрашиваем подтверждение (если скрипт запущен из консоли)
if (PHP_SAPI === 'cli') {
    echo "Продолжить удаление? (y/n): ";
    $handle = fopen('php://stdin', 'r');
    $answer = trim(fgets($handle));
    if ($answer !== 'y') {
        echo "Операция отменена.\n";
        exit;
    }
}

// Удаляем файлы
$deletedCount = 0;
foreach ($files as $file) {
    if (is_file($file) && unlink($file)) {
        $deletedCount++;
    } else {
        echo "Не удалось удалить: $file\n";
    }
}

echo "Удалено файлов: $deletedCount\n";