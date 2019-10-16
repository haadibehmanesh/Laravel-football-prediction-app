<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UserInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // dd($request);
       // return parent::toArray($request);
       return [
        'id' => $this->id,
        'score' =>$this->score,
        //'total' =>$this->totalWallet,
        'invitationCode' =>$this->invitation_code,
       // 'usage_terms' =>$this->usage_terms,

    
       ];
    }
}
