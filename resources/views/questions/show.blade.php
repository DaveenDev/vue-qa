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
                @include('shared._vote',[
                   'model' => $question
                ])    
                <div class="media-body">
                   {!! $question->body_html !!}
                   
                        @if(Gate::allows('update-question',$question))
                            <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info"> Edit</a>
                            <form class="form-delete " method="post" action="{{route('questions.destroy',$question->id)}}">
                                            @method('DELETE')
                                            @csrf
                                        <button type="Submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif  
                            <div class="row mb-3">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    @include('shared._author',[
                                            'model'=>$question,
                                            'label'=>'Asked'
                                        ])
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
</div>
@endsection
