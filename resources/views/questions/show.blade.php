@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>{{$question->title}}</h2>
                        <div class="ml-auto">
                        <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">back</a>
                        </div>
                    </div>
                    

                </div>

                <div class="card-body">
                   {!! $question->body_html !!}
                                        <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info"> Edit</a>
                                    <form class="form-delete " method="post" action="{{route('questions.destroy',$question->id)}}">
                                            @method('DELETE')
                                            @csrf
                                        <button type="Submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                             
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
