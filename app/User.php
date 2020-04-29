<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar','url'];

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
       return $this->_vote($voteQ,$question,$vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteA=$this->voteAnswers();
          return $this->_vote($voteA,$answer,$vote);
    }

    private function _vote($relationship, $model,$vote)
    {
        
        if($relationship->where('votable_id',$model->id)->exists()){
            $relationship->updateExistingPivot($model,['vote'=>$vote]);
            //dd("updated  1");
         }else{
             $relationship->attach($model,['vote'=>$vote]);
            //dd("added 1");
         }
 
         $model->load('votes'); //refresh the field value
         $up=(int) $model->upVotes()->sum('vote');
         $down=(int) $model->downVotes()->sum('vote');
         
         $model->votes_count=$up+$down;
         $model->save(); 
         
         return $model->votes_count;
    }

    public function posts()
    {
        //get post type from request
        $type=request()->get('type');
        if($type==='questions'){
            //get quetions posts
            $posts=$this->questions()->get();
        }else{
            //get answers posts
            $posts=$this->answers()->with('question')->get();
            
            if($type!=='answers'){
                $qPosts=$this->questions()->get();
                //merge answers and questions
               $posts= $posts->merge($qPosts);
            }
        }

        $data=collect();
        foreach($posts as $post)
        {
            $item=[
                'votes_count'=>$post->votes_count,
                'created_at'=>$post->created_at->format('M d Y')
            ];

            if($post instanceof Answer){
                $item['type']='A';
                $item['title']=$post->question->title;
                $item['accepted']=$post->question->best_answer_id===$post->id? true : false;
            }elseif($post instanceof Question){
                $item['type']='Q';
                $item['title']=$post->title;
                $item['accepted']= (bool)$post->best_answer_id;
            }
            $data->push($item);
        }

        return $data->sortByDesc('votes_count')->values()->all();
    }
}
