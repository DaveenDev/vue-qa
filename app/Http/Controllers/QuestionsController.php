<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
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
        //How to debug database Query
        //\DB::enableQueryLog();
        //$questions=Question::with('user')->latest()->paginate(5);
        //view('questions.index',compact('questions'))->render();
        //dd(\DB::getQueryLog());

        $questions=Question::with('user')->latest()->paginate(5);
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        //$validator = Validator::make($request->all(), [
        //    'title' => 'required|unique:posts|max:150',
        //    'body' => 'required|max:255',
       // ]);

        $request->user()->questions()->create($request->all()); //$request->only('title','body') if you want specific columns to add
        
        /*LONG METHOD
            $user = auth()->user();

            $newQ=new Question();
            $newQ->title=$request->title;
            $newQ->body=$request->body;
            $newQ->user_id=$user->id;
            $newQ->save();
        */
        return redirect()->route('questions.index')->with('success','Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view("questions.edit",compact('question'));
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
        $question->update($request->only('title','body'));
               
        return redirect('/questions')->with('success','Your question has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect('/questions')->with('success','Question has been deleted');
    }
}
