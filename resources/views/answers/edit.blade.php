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
                        <a title="Click to mark as favorite question (click again to undo)" class="favorite mt-2 favorited">
                            <i class="fa fa-star fa-lg"></i>
                            <span class="favorites-count">3</span>
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
                        <div class="row">
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
      
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                <form action="{{route('questions.answers.update',[$question->id,$answer->id])}}" method="post">
                       @csrf
                       @method('PUT')
                       <div class="form-group">
                       <textarea class="form-control {{$errors->has('body')? 'is-invalid': ''}}" rows=7 name="body">{{old('body',$answer->body)}}</textarea>
                            @if($errors->has('body'))
                                <strong>{{$errors->first('body')}}</strong>
                            @endif  
                       </div>
                       <div class="form-group">
                           <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
