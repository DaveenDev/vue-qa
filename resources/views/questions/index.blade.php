@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                        <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                    </div>
                    

                </div>

                <div class="card-body">
                    @include('layouts._messages')
                    @foreach ($questions as $q)
                        <div class="media">
                            <div class="d-flex flex-column counters">
                                <div class="vote">
                                    <strong>{{$q->votes_count}}</strong>{{Str::plural('vote',$q->votes_count)}}
                                </div>
                            <div class="status {{$q->status}}">
                                    <strong>{{$q->answers_count}}</strong>{{Str::plural('answers',$q->answers_count)}}
                                </div>
                                <div class="view">
                                    {{$q->views . " " . Str::plural('views',$q->views)}}
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0"> <a href="{{$q->url}}">{{$q->title}}</a></h3>
                                    
                                        <div class="ml-auto">
                                           @can('update',$q)
                                                <a href="{{route('questions.edit',$q->id)}}" class="btn btn-sm btn-outline-info"> Edit</a>
                                            @endcan
                                            @can('delete',$q)
                                                <form class="form-delete " method="post" action="{{route('questions.destroy',$q->id)}}">
                                                    @method('DELETE')
                                                    @csrf
                                                <button type="Submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    
                                </div>      
                            
                            <p class="lead">
                                Asked by <a href="{{$q->user->url}}">{{$q->user->name}}</a>
                                <small class="text-muted">{{$q->created_date}}</small>
                            </p>
                                {{Str::limit($q->body,100)}}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
