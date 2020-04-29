<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions=Question::with('user')->latest()->paginate(5);
        if(env('APP_ENV')=='local') sleep(2); //add  delay to the request
        return QuestionResource::collection($questions); //this is how to transform many objects into json
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $newquestion=$request->user()->questions()->create($request->only('title','body')); //$request->all() if you want all columns to add
        if(env('APP_ENV')=='local') sleep(2); //add  delay to the request
        return response()->json([
            'message'=>'Your question has been submitted',
            'question'=>new QuestionResource($newquestion)
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return response()->json([
            'title'=>$question->title,
            'body'=>$question->body,
            'body_html'=>$question->body_html
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update",$question);
        $question->update($request->only('title','body'));
    
            return response()->json([
                'message'=>'Your question has been updated.',
                'body_html'=>$question->body_html
            ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize("delete",$question);
        $question->delete();
        
            return response()->json([
                'message'=>'Question has been deleted'
            ]);
        
    }
}
