@extends('layouts.app')

@section('content')
<div class="container">
    
   
    <question-page :question="{{$question}}" :user="{{$question->user}}"></question-page>
        
    
</div>
@endsection
