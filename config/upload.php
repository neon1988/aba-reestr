<?php

return [
    'image_min_size' => '1kb',
    'image_max_size' => env('UPLOAD_MAX_PHOTO_SIZE', mb_strtolower(min([ini_get('upload_max_filesize'), ini_get('post_max_size')]) .'b')),
    'document_min_size' => '1kb',
    'document_max_size' => env('UPLOAD_MAX_DOCUMENT_SIZE', mb_strtolower(min([ini_get('upload_max_filesize'), ini_get('post_max_size')]) .'b')),
    'support_images_formats' => ['jpeg', 'gif', 'png'],
    'animation_max_image_width' => 1000, // максимальный размер ширины для анимированных изображений
    'animation_max_image_height' => 1000, // максимальный размер высоты для анимированных изображений
    'max_image_width' => 2000, // максимальный размер ширины изображения
    'max_image_height' => 2000, // максимальный размер высоты изображения
];
