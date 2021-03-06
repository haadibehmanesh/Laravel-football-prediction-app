<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class News extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'image' => $this->image,
            'video' => $this->video,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_fav' => $this->fav,
        ];
    }
}
