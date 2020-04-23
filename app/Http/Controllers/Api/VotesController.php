<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;

class VotesController extends Controller
{
    
    public function vote_question(Question $question)
    {
        $vote =(int) request()->vote;
       
        $voteCount= auth()->user()->voteQuestion($question,$vote);
            return response()->json([
                'message'=>'Thanks for the feedback',
                'votesCount'=> $voteCount
            ]);
        
    }

    public function vote_answer(Answer $answer)
    {
        $vote =(int) request()->vote;
        $voteCount=auth()->user()->voteAnswer($answer,$vote);
      
        
            return response()->json([
                'message'=>'Thanks for the feedback',
                'votesCount'=> $voteCount
            ]);
        
    }
  


}
