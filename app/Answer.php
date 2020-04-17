<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    use Functions;

    protected $fillable=['body','user_id'];
    protected $appends = ['created_date','body_html','is_best'];
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

    public function getStatusAttribute(){
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute(){
        return $this->isBest();
    }

    public function isBest(){
        return $this->id===$this->question->best_answer_id;
    }


    public static function boot(){
        parent::boot();

        //create class listener for when answer is created
        static::created(function ($answer){
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
        //create class listener for deletion of answer
        static::deleted(function ($answer){
            $question=$answer->question;
            $answer->question->decrement('answers_count');
            
            //check if the deleted answer was the best answer, then replace the best answer ID to null
            if($question->best_answer_id===$answer->id){
                $question->best_answer_id=NULL;
                $question->question->save();
            }
        });
    }

   
}
