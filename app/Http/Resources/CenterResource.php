<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        $array['photo'] = new FileResource($this->whenLoaded('photo'));
        $array['files'] = FileResource::collection($this->whenLoaded('files'));
        return $array;
    }
}
