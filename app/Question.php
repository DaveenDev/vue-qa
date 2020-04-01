<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $fillable=['title','body'];
    public function user(){
        return $this->belongsTo(User::class);
    }

      //define question - answer relationship
      public function answers(){
        return $this->hasMany(Answer::class);
    }

    //Mutators
    public function setTitleAttribute($value)
    {
        //when title is set to a value then the slug field will get an value with slug value too 
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);

    }

    //Accessors
    public function getUrlAttribute(){
        return route('questions.show',$this->slug); //return the attribute slug for the $question->url field
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        //returns answered status based on answer count field
        if ($this->answers_count>0){
            if($this->best_answer_id){
                return "answer-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute(){
        //parse the markdown into html ex. \n into <br>
       return  \Parsedown::instance()->text($this->body);
    }

  
}
