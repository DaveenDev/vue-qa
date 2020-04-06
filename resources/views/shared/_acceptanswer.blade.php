@can('acceptbestanswer',$model)
<a title="Mark this as Best Answer" 
    class="{{$model->status}} mt-2 "
    onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit();"
    >
    <i class="fa fa-check fa-2x"></i>
</a>

<!-- hidden form targeted by the mark as best answer tag A -->
<form id="accept-answer-{{$model->id}}" method="POST" action="{{route('answers.accept',$model->id)}}" style="display: none">
    @csrf
</form>
@else
@if($model->is_best)
    <a title="Best Answer marked by question owner" 
        class="{{$model->status}} mt-2 ">
        <i class="fa fa-check fa-2x"></i>
    </a>
@endif
@endcan