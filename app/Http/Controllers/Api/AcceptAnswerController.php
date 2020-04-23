<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    //Single action controller
    public function __invoke(Answer $answer)
    {
        $this->authorize('acceptbestanswer', $answer);
        //$answer->question->acceptBestAnswer($answer);
        $answer->question->best_answer_id=$answer->id;
        $answer->question->save();

        
            return response()->json([
               'message'=>'You have accepted this answer as the BEST ANSWER'
            ]);
        
    }
}
