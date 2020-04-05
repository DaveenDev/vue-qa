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

    public function votequestion(Question $question)
    {
        $vote =(int) request()->vote;
       
        auth()->user()->voteQuestion($question,$vote);
        return back();
    }

    public function voteanswer(Answer $answer)
    {
        $vote =(int) request()->vote;
       
        auth()->user()->voteAnswer($answer,$vote);
        return back();
    }
  


}
