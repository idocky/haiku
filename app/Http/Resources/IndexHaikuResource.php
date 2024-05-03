<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexHaikuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'is_hidden' => $this->is_hidden,
            'published_at' => $this->published_at,
            'user' => new UserResource($this->user),
            'theme' => new ThemesResource($this->resource)
        ];
    }
}
