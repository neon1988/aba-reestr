<?php

namespace Database\Factories;

use Imagick;
use ImagickPixel;

trait RandomImageGenerator
{
    public static function generateRandomImage($width = 500, $height = 500)
    {
        // Создаем новый объект Imagick
        $imagick = new Imagick();

        // Генерируем случайный цвет для фона
        $backgroundColor = new ImagickPixel(self::getRandomColor());
        $imagick->newImage($width, $height, $backgroundColor);

        // Добавляем случайный узор или рисунок
        self::addRandomPattern($imagick, $width, $height);

        // Преобразуем изображение в формат JPEG
        $imagick->setImageFormat('jpeg');

        return $imagick;
    }

    private static function getRandomColor()
    {
        // Генерируем случайный цвет в формате #RRGGBB
        $randomColor = sprintf('#%02X%02X%02X', mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        return $randomColor;
    }

    private static function addRandomPattern(Imagick $imagick, $width, $height)
    {
        // Добавляем случайные линии
        $draw = new \ImagickDraw();
        $draw->setStrokeWidth(2);
        $draw->setStrokeColor(new ImagickPixel(self::getRandomColor()));

        // Рисуем случайные линии
        for ($i = 0; $i < 10; $i++) {
            $x1 = mt_rand(0, $width);
            $y1 = mt_rand(0, $height);
            $x2 = mt_rand(0, $width);
            $y2 = mt_rand(0, $height);
            $draw->line($x1, $y1, $x2, $y2);
        }

        // Рисуем случайные окружности
        for ($i = 0; $i < 5; $i++) {
            $x = mt_rand(0, $width);
            $y = mt_rand(0, $height);
            $radius = mt_rand(20, 100);
            $draw->setStrokeColor(new ImagickPixel(self::getRandomColor()));
            $draw->setFillColor(new ImagickPixel(self::getRandomColor()));
            $draw->ellipse($x, $y, $radius, $radius, 0, 360);
        }

        // Применяем рисунок на изображение
        $imagick->drawImage($draw);
    }
}
