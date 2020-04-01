@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>{{$question->title}}</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">back</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="media">
                    <div class="d-flex flex-column vote-controls">
                        <a title="This question is useful" class="vote-up">
                            <i class="fa fa-caret-up fa-2x"></i>
                        </a>
                        <span class="votes-count">1230</span>
                        <a title="This question is not useful" class="vote-down off">
                            <i class="fa fa-caret-down fa-2x"></i>
                        </a>
                        <a title="Click to mark as favorite question (click again to undo)" class="favorite mt-2 favorited">
                            <i class="fa fa-star fa-lg"></i>
                            <span class="favorites-count">123</span>
                        </a>
                    </div>
                <div class="media-body">
                   {!! $question->body_html !!}
                   
                        @if(Gate::allows('update-question',$question))
                            <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info"> Edit</a>
                            <form class="form-delete " method="post" action="{{route('questions.destroy',$question->id)}}">
                                            @method('DELETE')
                                            @csrf
                                        <button type="Submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>chec
                        @endif  
                        <div class="float-right">
                            <span class="text-muted">Created: {{$question->created_date}}</span>
                            <div class="media">
                                <a href="{{$question->user->url}}" class="pr-2">
                                    <img src="{{$question->user->avatar}}"> 
                                </a>
                            
                                <div class="media-body">
                                    <a href="{{$question->user->url}}">
                                    {{$question->user->name}}
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{$question->answers_count. " " . Str::plural('Answer',$question->answers_count)}}</h3>
                    </div>
                    <hr>
                    @foreach($question->answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is useful" class="vote-up">
                                <i class="fa fa-caret-up fa-2x"></i>
                            </a>
                            <span class="votes-count">1230</span>
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fa fa-caret-down fa-2x"></i>
                            </a>
                            <a title="Mark this as Best Answer" class="vote-accept mt-2">
                                <i class="fa fa-check fa-2x"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
       
                            <div class="float-right">
                                <span class="text-muted">Answered: {{$answer->created_date}}</span>
                                <div class="media">
                                    <a href="{{$answer->user->url}}" class="pr-2">
                                        <img src="{{$answer->user->avatar}}"> 
                                    </a>
                                
                                <div class="media-body">
                                    <a href="{{$answer->user->url}}">
                                        {{$answer->user->name}}
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
