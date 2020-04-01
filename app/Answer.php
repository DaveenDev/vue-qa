<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute(){
        //parse the markdown into html ex. \n into <br>
       return  \Parsedown::instance()->text($this->body);
    }

       public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }


}
