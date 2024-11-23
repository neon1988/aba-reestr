<?php

if (!function_exists('formatFileSize')) {
    /**
     * Преобразует размер файла в человекочитаемый формат
     *
     * @param  int  $bytes
     * @param  int  $precision
     * @return string
     */
    function formatFileSize($bytes, $precision = 2)
    {
        $units = ['Б', 'Кб', 'Мб', 'Гб', 'Тб'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . '' . $units[$pow];
    }
}

function convertToBytes($size) {
    // Список поддерживаемых единиц с их кратностью
    $units = [
        'B'  => 1,
        'K'  => 1024,
        'KB' => 1024,
        'M'  => 1024 ** 2,
        'MB' => 1024 ** 2,
        'G'  => 1024 ** 3,
        'GB' => 1024 ** 3,
        'T'  => 1024 ** 4,
        'TB' => 1024 ** 4,
        'P'  => 1024 ** 5,
        'PB' => 1024 ** 5,
    ];

    // Удаляем пробелы и переводим строку в верхний регистр
    $size = strtoupper(trim($size));

    // Ищем в строке числа и единицы измерения
    if (preg_match('/^([\d.]+)\s*([KMGTPE]B?|B)?$/i', $size, $matches)) {
        $value = (float)$matches[1]; // Числовое значение
        $unit = $matches[2] ?? 'B';  // Единица измерения (по умолчанию байты)

        // Проверяем, существует ли единица в массиве
        if (isset($units[$unit])) {
            return $value * $units[$unit];
        }
    }

    throw new InvalidArgumentException("Invalid size format: $size");
}


function fileNameFormat($name): array|string|null
{
    $i = 0;

    do {
        $encoded_name = $name;
        $name = urldecode($encoded_name);
        $i++;
    } while ($name != $encoded_name and $i < 50);

    $name = replaceAsc194toAsc32($name);
    $name = transliterator_transliterate("Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC", $name);
    $name = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/ui', '', $name);
    $name = preg_replace("/([^[:alnum:]_.№ ~$^&\[\]()])+/iu", "", $name);
    $name = preg_replace("/[[:space:]]+/iu", "_", $name);
    $name = str_replace('ʹ', "'", $name);
    $name = trim($name, '_');
    $name = rtrim($name, '.');
    $name = preg_replace("/(_)+/iu", "_", $name);

    if (mb_strlen($name) >= 200) {

        if (preg_match('/(.*)\.([[:alnum:]]{2,5})\.([[:alnum:]]{2,5})$/iu', $name, $matches)) {

            $name = mb_substr($matches[1], 0, 200 - mb_strlen($matches[2]) - mb_strlen($matches[3]) - 2) . '.' . $matches[2] . '.' . $matches[3];

        } elseif (preg_match('/(.*)\.([[:alnum:]]{2,5})$/iu', $name, $matches)) {

            $name = mb_substr($matches[1], 0, 200 - mb_strlen($matches[2]) - 2) . '.' . $matches[2];
        } else {
            $name = mb_substr($name, 0, 200);
        }
    }

    return $name;
}

function replaceAsc194toAsc32($s): string
{
    mb_substitute_character(0x20);
    $s = mb_convert_encoding($s, "UTF-8", "auto");

    return mb_str_replace(chr(194) . chr(160), ' ', $s);
}

if (!function_exists("mb_str_replace")) {
    function mb_str_replace($needle, $replace_text, $haystack): string
    {
        return implode($replace_text, mb_split($needle, $haystack));
    }
}

function replaceSimilarSymbols($searchText): string
{
    $searchText = mb_str_replace('ё', 'е', $searchText);
    return mb_str_replace('Ё', 'Е', $searchText);
}
