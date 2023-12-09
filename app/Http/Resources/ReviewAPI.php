<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewAPI extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'score' => $this->score,
            'is_approved' => $this->is_approved,
            'user' => new UserAPI($this->user),
            'localGame' => new GameAPI($this->localGame),
        ];
    }
}

