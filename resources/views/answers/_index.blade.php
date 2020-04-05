
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{$answersCount. " " . Str::plural('Answer',$answersCount)}}</h3>
                    </div>
                    <hr>
                    @include('layouts._messages')
                    @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is useful" 
                                class="vote-up {{Auth::guest() ? 'off':''}}"
                                onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{$answer->id}}').submit()"
                                >
                                <i class="fa fa-caret-up fa-2x"></i>
                            </a>
                            <form id="up-vote-answer-{{$answer->id}}" method="Post" action="/answers/{{$answer->id}}/vote" style="display: none">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                        <span class="votes-count">{{$answer->votes_count}}</span>
                            <a title="This answer is not useful" 
                                class="vote-down {{Auth::guest() ? 'off':''}}"
                                onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{$answer->id}}').submit()"
                                >
                                <i class="fa fa-caret-down fa-2x"></i>
                            </a>
                            <form id="down-vote-answer-{{$answer->id}}" method="Post" action="/answers/{{$answer->id}}/vote" style="display: none">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
                            @can('acceptbestanswer',$answer)
                                <a title="Mark this as Best Answer" 
                                    class="{{$answer->status}} mt-2 "
                                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();"
                                    >
                                    <i class="fa fa-check fa-2x"></i>
                                </a>
                                
                                <!-- hidden form targeted by the mark as best answer tag A -->
                                <form id="accept-answer-{{$answer->id}}" method="POST" action="{{route('answers.accept',$answer->id)}}" style="display: none">
                                    @csrf
                                </form>
                            @else
                                @if($answer->is_best)
                                    <a title="Best Answer marked by question owner" 
                                        class="{{$answer->status}} mt-2 ">
                                        <i class="fa fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
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
                                <div class="col-4">
                                    
                                </div>
                                <div class="col-4">
                                    <span class="text-muted">Answered: {{$answer->created_date}}</span>
                                    <div class="media">
                                        <a href="{{$answer->user->url}}" class="pr-2">
                                            <img src="{{$answer->user->avatar}}"> 
                                        </a>
                                    
                                    <div class="media-body">
                                        <a href="{{$answer->user->url}}">
                                            {{$answer->user->name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                          
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
