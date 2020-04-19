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

                        <vote :model="{{$q}}" name="question"></vote>
                            
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
                            <div class="excerpt">
                                {{ $q->excerpt(350) }}
                            </div>
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
