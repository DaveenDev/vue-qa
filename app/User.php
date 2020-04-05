<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relationships
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function favorites(){
        return $this->belongsToMany(App\Question::class,'favorites','user_id','question_id')->withTimeStamps();
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class,'votable'); //make the 2nd argument in singular form Eloquent recognize the table is votables
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class,'votable'); //make the 2nd argument in singular form Eloquent recognize the table is votables
    }

    //AcCessors
    public function getUrlAttribute(){
        //return route('questions.show',$this->id);
        return '#';
    }

    public function getAvatarAttribute(){
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQ=$this->voteQuestions();
        if($voteQ->where('votable_id',$question->id)->exists()){
           $voteQ->updateExistingPivot($question,['vote'=>$vote]);
        }else{
            $voteQ->attach($question,['vote'=>$vote]);
        }

        $question->load('votes'); //refresh the field value
        $up=(int) $question->upVotes()->sum('vote');
        $down=(int) $question->downVotes()->sum('vote');
        $question->votes_count=$up+$down;
        $question->save(); 
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteA=$this->voteAnswers();
        if($voteA->where('votable_id',$answer->id)->exists()){
           $voteA->updateExistingPivot($answer,['vote'=>$vote]);
        }else{
            $voteA->attach($answer,['vote'=>$vote]);
        }

        $answer->load('votes'); //refresh the field value
        $up=(int) $answer->upVotes()->sum('vote');
        $down=(int) $answer->downVotes()->sum('vote');
        $answer->votes_count=$up+$down;
        $answer->save(); 
    }
}
