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
        $array['url'] = Storage::disk($array['storage'])->url($array['dirname'] . '/' . $array['name']);
        $array['path'] = (string)Url::fromString($array['dirname'] . '/' . $array['name']);
        return $array;
    }
}
