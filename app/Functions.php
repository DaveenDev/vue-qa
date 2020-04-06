<?php 
namespace App;

trait Functions
{
   
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