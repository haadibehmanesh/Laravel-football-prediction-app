<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamStandings extends JsonResource
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
            'team_id' => $this->team_id,
            'league_id' => $this->league_id,
            'score' => $this->score,
            'win' => $this->win,
            'draw' => $this->draw,
            'loss' => $this->loss,
            'gf' => $this->gf,
            'ga' => $this->ga,
            'gd' => $this->gd,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
