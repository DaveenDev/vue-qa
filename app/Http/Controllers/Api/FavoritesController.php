<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
  
        return response()->json('You have mark this question as favorite');
  
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());
        return response()->json('You have unfavorite this question');

        
    }
}
