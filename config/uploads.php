<?php

return [
    'image_max_size' => env('UPLOADS_MAX_PHOTO_SIZE', 2048000),  // Максимальный размер фото (в КБ)
    'document_max_size' => env('UPLOADS_MAX_DOCUMENT_SIZE', 5120000),  // Максимальный размер документа (в КБ)
    'support_images_formats' => ['jpeg', 'gif', 'png'],
    'animation_max_image_width' => 1000, // максимальный размер ширины для анимированных изображений
    'animation_max_image_height' => 1000, // максимальный размер высоты для анимированных изображений
    'max_image_width' => 2000, // максимальный размер ширины изображения
    'max_image_height' => 2000, // максимальный размер высоты изображения
];
