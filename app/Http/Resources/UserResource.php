<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        $array['photo'] = new ImageResource($this->whenLoaded('photo'));
        $array['specialists'] = SpecialistResource::collection($this->whenLoaded('specialists'));
        $array['centers'] = CenterResource::collection($this->whenLoaded('centers'));
        return $array;
    }
}
