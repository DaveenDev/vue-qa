<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
      
    protected $fillable=['title','body'];
    protected $dates=['created_at','updated_at'];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url','created_date','is_favorited','favorites_count','body_html','excerpt'];

    public function user(){
        return $this->belongsTo(User::class);
    }

      //define question - answer relationship
      public function answers(){
        return $this->hasMany(Answer::class);
        //return $this->hasMany(Answer::class)->orderBy('votes_count','DESC'); how to add order by query
    }

    public function favorites(){
        return $this->belongsToMany(User::class,'favorites','question_id','user_id')->withTimeStamps();
    }

    
    //Mutators
    public function setTitleAttribute($value)
    {
        //when title is set to a value then the slug field will get an value with slug value too 
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);
    }

    /*public function setBodyAttribute($value)
    {
        //when title is set to a value then the slug field will get an value with slug value too 
        $this->attributes['body']=clean($value);
    }*/


    //Accessors
    public function getUrlAttribute(){
        return route('questions.show',$this->slug); //return the attribute slug for the $question->url field
    }

    public function getCreatedDateAttribute(){
        //$date=Carbon::parse(created_at);
        
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
      return clean($this->bodyHtml());
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(300);
    }

    public function excerpt($length)
    {
        return Str::limit(strip_tags($this->bodyHtml),$length);
    }

    private function bodyHtml()
    {
        return  \Parsedown::instance()->text($this->body);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id=$answer->id;
        $this->save();
    }

    public function is_Favorited()
    {
        return $this->favorites()->where('user_id',auth()->id())->count()>0;
    }
    
    public function getIsFavoritedAttribute()
    {
        return $this->is_Favorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function votes()
    {
        return $this->morphToMany(User::class,'votable'); //make the 2nd argument in singular form Eloquent recognize the table is votables
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote',1); //return the collection of votes +1
         
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote',-1); //return the collection of votes -1
        
    }
     
}
