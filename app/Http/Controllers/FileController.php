<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;
use Litlife\Url\Url;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class FileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request): FileResource
    {
        $this->authorize('create', File::class);

        $upload = $request->file('file');
        $stream = fopen($upload, 'r');
        $extension = Url::fromString($upload->getClientOriginalName())->getExtension();
        $name = $upload->getClientOriginalName();

        if (str_starts_with($upload->getMimeType(), 'image/')) {
            try {
                $image = new Imagick();
                $image->readImageFile($stream);
                if (strpos($image->getImageMimeType(), 'image/') === 0)
                {
                    $orientation = $image->getImageOrientation();
                    switch($orientation) {
                        case imagick::ORIENTATION_BOTTOMRIGHT:
                            $image->rotateimage(new ImagickPixel('none'), 180); // rotate 180 degrees
                            break;
                        case imagick::ORIENTATION_RIGHTTOP:
                            $image->rotateimage(new ImagickPixel('none'), 90); // rotate 90 degrees CW
                            break;
                        case imagick::ORIENTATION_LEFTBOTTOM:
                            $image->rotateimage(new ImagickPixel('none'), -90); // rotate 90 degrees CCW
                            break;
                    }
                    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
                    $image->stripImage();
                    // Проверяем, нужно ли уменьшать изображение
                    if ($image->getImageWidth() > config('upload.max_image_width') ||
                        $image->getImageHeight() > config('upload.max_image_height')) {
                        $image->thumbnailImage(
                            config('upload.max_image_width'),
                            config('upload.max_image_height'),
                            true
                        );
                    }

                    $image->setImageCompressionQuality(90);
                    $image->setImageFormat('webp');

                    $extension = 'webp';
                    $name = Url::fromString($name)->withExtension($extension);

                    $stream = fopen('php://memory', 'r+'); // Создаем поток в памяти
                    fwrite($stream, $image->getImageBlob()); // Записываем данные
                    rewind($stream); // Перемещаем указатель в начало
                }

            } catch (\Exception $e) {

            }
        }

        $file = new File();
        $file->open($stream, $extension);
        $file->storage = 'temp';
        $file->name = $name;
        $file->save();

        return new FileResource($file);
    }

    /**
     * Скачивание файла
     *
     * @param File $file
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function download(File $file): Response|RedirectResponse
    {
        $this->authorize('download', $file);

        if ($file->trashed() or !$file->exists())
            return response('File not found.', HttpResponse::HTTP_NOT_FOUND);

        if ($file->storage == 'private') {
            return response('')
                ->header('X-Accel-Redirect', $file->url)
                ->header('Content-Disposition', 'attachment; filename="' . $file->name . '"')
                ->header('Content-Type', 'application/x-force-download')
                ->header('Cache-Control', 'public, max-age=' . intval(60 * 60 * 31))  // Устанавливает кэш на 24 часа
                ->header('Last-Modified', gmdate('D, d M Y H:i:s', strtotime($file->updated_at)) . ' GMT')
                ->header('ETag', md5($file->id . $file->updated_at . $file->size));
        } else {
            return redirect()->to($file->url);
        }
    }
}
