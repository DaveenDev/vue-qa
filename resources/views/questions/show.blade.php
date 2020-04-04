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
                        <span class="votes-count">12</span>
                        <a title="This question is not useful" class="vote-down off">
                            <i class="fa fa-caret-down fa-2x"></i>
                        </a>
                        <a title="Click to mark as favorite question (click again to undo)" 
                            onclick="event.preventDefault(); document.getElementById('fav-question-{{$question->id}}').submit();"
                            class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                            >
                            <i class="fa fa-star fa-2x"></i>
                            <span class="favorites-count">{{$question->favorites_count}}</span>
                    
                        </a>
                        <form id="fav-question-{{$question->id}}" method="Post" action="/questions/{{$question->id}}/favorites" style="display: none">
                            @csrf
                            @if($question->is_Favorited)
                                @method('Delete')
                            @endif  
                        </form>
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
      
    </div>

    @include('answers._index',[
        'answers'=>$question->answers,
        'answersCount'=>$question->answers_count,
    ])

    @include('answers._create')
</div>
@endsection
