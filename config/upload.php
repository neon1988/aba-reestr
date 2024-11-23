<?php

return [
    'image_min_size' => '1kb',
    'image_max_size' => env('UPLOAD_MAX_PHOTO_SIZE', '10M'),
    'document_max_size' => env('UPLOAD_MAX_DOCUMENT_SIZE', '50M'),
    'support_images_formats' => ['jpeg', 'gif', 'png'],
    'animation_max_image_width' => 1000, // максимальный размер ширины для анимированных изображений
    'animation_max_image_height' => 1000, // максимальный размер высоты для анимированных изображений
    'max_image_width' => 2000, // максимальный размер ширины изображения
    'max_image_height' => 2000, // максимальный размер высоты изображения
];
