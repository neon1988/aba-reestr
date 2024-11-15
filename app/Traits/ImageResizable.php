<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imagick;
use ImagickException;
use Litlife\Url\Url;
use Psr\Http\Message\StreamInterface;

trait ImageResizable
{
    use Storable;

    public ?int $maxWidth = null;
    public ?int $maxHeight = null;
    public ?int $quality = null;
    public ?Imagick $imagick = null;

    public $source = null;

    public function setMaxWidthAttribute($width)
    {
        $this->maxWidth = intval($width);
    }

    public function setMaxHeightAttribute($height)
    {
        $this->maxHeight = intval($height);
    }

    public function setQualityAttribute($quality)
    {
        $this->quality = intval($quality);
    }

    public function getfullUrlSizedAttribute(): string
    {
        $url = Url::fromString($this->url);

        if (!empty($this->maxWidth) and !empty($this->maxHeight)) {
            $url = $url->withQueryParameter('w', $this->maxWidth)
                ->withQueryParameter('h', $this->maxHeight);
        } elseif (!empty($this->maxWidth)) {
            $url = $url->withQueryParameter('w', $this->maxWidth);
        } elseif (!empty($this->maxHeight)) {
            $url = $url->withQueryParameter('h', $this->maxHeight);
        }

        if (!empty($this->quality))
            $url = $url->withQueryParameter('q', $this->quality);

        return (string)$url;
    }

    public function fullUrlMaxSize($width, $height, $quality = 90)
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
        $this->quality = $quality;

        return $this->fullUrlSized;
    }

    public function getUrlWithImageResolution($width, $height)
    {
        $model = &$this;
        $model->maxWidth = intval($width);
        $model->maxHeight = intval($height);
        return $model->fullUrlSized;
    }

    public function getFullUrl200x200Attribute()
    {
        $this->maxWidth = 200;
        $this->maxHeight = 200;

        return $this->fullUrlSized;
    }

    public function getFullUrl90x90Attribute()
    {
        $this->maxWidth = 90;
        $this->maxHeight = 90;

        return $this->fullUrlSized;
    }

    public function getFullUrl50x50Attribute()
    {
        $this->maxWidth = 50;
        $this->maxHeight = 50;

        return $this->fullUrlSized;
    }

    public function getFullUrlAttribute()
    {
        return $this->url;
    }

    public function getRealWidth(): ?int
    {
        $frames = $this->getImagick()->coalesceImages();

        foreach ($frames as $frame)
            return $frame->getImageWidth();

        return null;
    }

    public function getImagick(): Imagick
    {
        if (!empty($this->getKey())) {
            if (empty($this->imagick)) {
                $this->imagick = new Imagick();
                $this->imagick->readImageFile($this->getStream());
            }
        }

        return $this->imagick;
    }

    public function getRealHeight(): ?int
    {
        $frames = $this->getImagick()->coalesceImages();

        foreach ($frames as $frame)
            return $frame->getImageHeight();
        return null;
    }

    /**
     * @throws ImagickException
     * @throws Exception
     * @throws GuzzleException
     */
    public function openImage($source, $type = null, $throughImagick = true)
    {
        if (!$throughImagick) {
            $this->openImageNotThroughImagick($source, $type);
        } else {
            if (is_string($source)) {
                if (preg_match('/^data:image\/(?:[A-z]+);base64,(.*)/iu', $source, $matches)) {
                    list (, $base64) = $matches;

                    $source = $base64;
                    $type = 'base64';
                }
            }

            if ($type == 'blob') {
                $this->imagick = new Imagick();
                $this->imagick->readImageBlob($source);
            } elseif ($type == 'base64') {
                $this->imagick = new Imagick();
                $this->imagick->readImageBlob(base64_decode($source));
            } elseif ($type == 'url') {
                $this->imagick = new Imagick();
                $this->imagick->readImageBlob($this->downloadThrougnGuzzle($source)->getContents());

                if (empty($this->name))
                    $this->name = Url::fromString($source)->getBasename();
            } elseif (is_string($source) and file_exists($source)) {
                $this->imagick = new Imagick($source);

                if (empty($this->name))
                    $this->name = Url::fromString($source)->getBasename();

            } elseif (is_object($source) and get_class($source) == 'Imagick') {
                $this->imagick = $source;
            } elseif (is_resource($source)) {
                $this->imagick = new Imagick();
                rewind($source);
                $this->imagick->readImageFile($source);
            } else {
                $this->imagick = new Imagick($source);
            }

            if (in_array(mb_strtolower($this->imagick->getImageFormat()), ['svg', 'mvg']))
                throw new Exception('Unsupport image extension');

            if (!in_array(strtolower($this->imagick->getImageFormat()), config('uploads.support_images_formats')))
                $this->imagick->setImageFormat('jpeg');

            if (strtolower($this->imagick->getImageFormat()) == 'gif') {
                if (($this->imagick->getImageWidth() > config('uploads.animation_max_image_width')) or ($this->imagick->getImageHeight() > config('uploads.animation_max_image_height'))) {

                    $this->imagick = $this->imagick->coalesceImages();

                    foreach ($this->imagick as $frame)
                        $frame->scaleImage(config('uploads.animation_max_image_width'), config('uploads.animation_max_image_height'), true);
                }
            } else {
                if (($this->imagick->getImageWidth() > config('uploads.max_image_width')) or
                    ($this->imagick->getImageHeight() > config('uploads.max_image_height'))) {

                    $this->imagick = $this->imagick->coalesceImages();

                    foreach ($this->imagick as $frame)
                        $frame->scaleImage(config('uploads.max_image_width'), config('uploads.max_image_height'), true);
                }
            }

            $this->source = tmpfile();

            $this->imagick->writeImagesFile($this->source);

            $this->imagick = new Imagick();
            $this->imagick->readImageFile($this->source);
        }
    }

    public function openImageNotThroughImagick($source, $type = null)
    {
        if ($type == 'blob') {
            $this->source = tmpfile();
            fwrite($this->source, $source);
            rewind($this->source);
        }

        $this->imagick = new Imagick();
        $this->imagick->readImageFile($this->source);

        rewind($this->source);
    }

    /**
     * @throws GuzzleException
     */
    public function downloadThrougnGuzzle($url): StreamInterface
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36',
            'Referer' => (string)Url::fromString($url)->withPath('/')
        ];

        $client = new Client();

        return $client->request('GET', $url, [
            'allow_redirects' => [
                'max' => 5,        // allow at most 10 redirects.
                'strict' => false,      // use "strict" RFC compliant redirects.
                'referer' => true,      // add a Referer header
            ],
            'connect_timeout' => 5,
            'read_timeout' => 10,
            'headers' => $headers,
            'timeout' => 5
        ])->getBody();
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getSha256Hash(): string
    {
        return $this->getImagick()->getImageSignature();
    }
}
