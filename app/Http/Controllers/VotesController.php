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
       
        $voteCount= auth()->user()->voteQuestion($question,$vote);
        if (request()->expectsJson()){
            return response()->json([
                'message'=>'Thanks for the feedback',
                'votesCount'=> $voteCount
            ]);
        }
        return back();
    }

    public function vote_answer(Answer $answer)
    {
        $vote =(int) request()->vote;
        $voteCount=auth()->user()->voteAnswer($answer,$vote);
      
        if (request()->expectsJson()){
            return response()->json([
                'message'=>'Thanks for the feedback',
                'votesCount'=> $voteCount
            ]);
        }
        return back();
    }
  


}
