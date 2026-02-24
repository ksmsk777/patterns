<?php
/**
 * Скрипт для скачивания страниц с пагинацией вида domen.ru/cars/{i}.html
 * Сохраняет файлы в заданную папку.
 */

// ---------- НАСТРОЙКИ ----------
$baseUrl = 'https://top.mail.ru/Rating/MassMedia/Today/Visitors/';   // Базовый URL (без номера страницы)
$start = 1;                           // Начальная страница
$end = 20;                            // Конечная страница
$folder = '../data/SMI';          // Папка для сохранения файлов
// --------------------------------

// Создаём папку, если её нет
if (!is_dir($folder)) {
    if (!mkdir($folder, 0777, true)) {
        die("Не удалось создать папку '$folder'.\n");
    }
    echo "Папка '$folder' создана.\n";
}

for ($i = $start; $i <= $end; $i++) {
    $url = $baseUrl . $i . '.html';
    $localFile = $folder . DIRECTORY_SEPARATOR . $i . '.html';

    echo "Скачиваю: $url... ";

    // Загружаем содержимое
    $content = @file_get_contents($url); // @ подавляет предупреждения

    if ($content !== false) {
        file_put_contents($localFile, $content);
        echo "OK (сохранено в $localFile)\n";
    } else {
        echo "ОШИБКА: страница не загружена (возможно, не существует)\n";
    }

    // Небольшая задержка, чтобы не нагружать сервер
    sleep(1);
}

echo "\nГотово! Файлы сохранены в папку '$folder'.\n";