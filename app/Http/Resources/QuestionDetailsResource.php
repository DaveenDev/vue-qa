<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionDetailsResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'votes_count'=>$this->votes_count,
            'answers_count'=>$this->answers_count,
            'is_favorited'=>$this->is_favorited,
            'body'=>$this->body,
            'body_html'=>$this->body_html,
            'created_date'=>$this->created_date,
            'user'=>new UserResource($this->user)  //how to transfer a single model into json
        ];
    }
}
