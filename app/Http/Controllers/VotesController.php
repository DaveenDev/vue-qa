<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function vote_question(Question $question)
    {
        $vote =(int) request()->vote;
       
        auth()->user()->voteQuestion($question,$vote);
        
        return back();
    }

    public function vote_answer(Answer $answer)
    {
        $vote =(int) request()->vote;
        auth()->user()->voteAnswer($answer,$vote);
       
        return back();
    }
  


}
