<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Games extends JsonResource
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
            'team1_name' => $this->team1_name,
            'team2_name' => $this->team2_name,
            'team1_goals' => $this->team1_goals,
            'team2_goals' => $this->team2_goals,
            'game_time' => $this->game_time,
            'game_date' => $this->game_date,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
