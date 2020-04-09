@if($model instanceof App\Question)
    @php
        $name="question"; 
        $name_uri='questions'
    @endphp
@elseif($model instanceof App\Answer)
    @php
        $name="answer";    
        $name_uri='answers'
    @endphp
@endif

@php
    $formID=$name . "-" . $model->id;
    $formAction="/". $name_uri ."/". $model->id ."/vote";
    
@endphp

<div class="d-flex flex-column vote-controls">
    <a title="This {{$name}} is useful" 
        class="vote-up {{Auth::guest()? 'off': ''}}" 
        onclick="event.preventDefault(); document.getElementById('up-vote-{{$formID}}').submit()"
        >
        <i class="fa fa-caret-up fa-2x"></i>
    </a>
    <form id="up-vote-{{$formID}}" method="Post" action="{{$formAction}}" style="display: none">
        @csrf
        <input type="hidden" name="vote" value=1>
    </form>
    <span class="votes-count">{{$model->votes_count}}</span>
    <a title="This {{$name}} is not useful" 
        class="vote-down {{Auth::guest()? 'off': ''}}"
        onclick="event.preventDefault(); document.getElementById('down-vote-{{$formID}}').submit()"
        >
        <i class="fa fa-caret-down fa-2x"></i>
    </a>
    <form id="down-vote-{{$formID}}" method="Post" action="{{$formAction}}" style="display: none">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
   
    @if($model instanceof App\Question)
        @include('shared._favorite',[
            'model'=>$model
        ])
    @else
        @include('shared._acceptanswer',[
            'model'=>$model
        ])
    @endif
</div>