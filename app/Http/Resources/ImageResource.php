<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        if (!empty($array['storage']) && !empty($array['dirname']) && !empty($array['name'])) {
            $filePath = $array['dirname'] . '/' . $array['name'];
            $array['url'] = Storage::disk($array['storage'])->url($filePath);
            $array['path'] = (string)Url::fromString($filePath);
        }
        return $array;
    }
}
