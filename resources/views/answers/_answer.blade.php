<div class="post media">
    @include('shared._vote',[
        'model'=>$answer
    ])
    <div class="media-body">
        {!! $answer->body_html !!}
        <div class="row">
            <div class="col-3">
                @can('update',$answer)
                            <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-sm btn-outline-info"> Edit</a>
                @endcan
                @can('delete',$answer)
                            <form class="form-delete " method="post" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}">
                                @method('DELETE')
                                @csrf
                            <button type="Submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                @endcan
            </div>
            <div class="col-3">            </div>
            <div class="col-3">            </div>
            <div class="col-3">
                
                <!-- Show Each Answer Author -->
                <user-info :model="{{$answer}}" :user="{{$answer->user}}" label="Answered"></user-info>
            </div>
        </div>
      
    </div>
</div>