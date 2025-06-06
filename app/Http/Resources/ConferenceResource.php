<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        $array['cover'] = new FileResource($this->whenLoaded('cover'));
        $array['file'] = new FileResource($this->whenLoaded('file'));
        return $array;
    }
}
