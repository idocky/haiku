<?php

namespace App\Http\Resources;

use App\Models\Haiku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditHaikuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'themes' => ThemesResource::collection($this->resource['themes']),
            'haiku' => new IndexHaikuResource($this->resource['haiku'])
        ];
    }
}
