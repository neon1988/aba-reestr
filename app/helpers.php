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
        $units = ['Б', 'КБ', 'МБ', 'ГБ', 'ТБ'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
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
