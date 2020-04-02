
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
                            <a title="This answer is useful" class="vote-up">
                                <i class="fa fa-caret-up fa-2x"></i>
                            </a>
                            <span class="votes-count">4</span>
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fa fa-caret-down fa-2x"></i>
                            </a>
                            <a title="Mark this as Best Answer" class="vote-accept mt-2">
                                <i class="fa fa-check fa-2x"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
       
                            <div class="float-right">
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
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
