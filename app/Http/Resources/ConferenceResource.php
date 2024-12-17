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
        $array['creator'] = new UserResource($this->whenLoaded('creator'));
        $array['cover'] = new ImageResource($this->whenLoaded('cover'));
        $array['file'] = new FileResource($this->whenLoaded('file'));
        return $array;
    }
}
