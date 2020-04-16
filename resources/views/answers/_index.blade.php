
   @if($answersCount>0)
        <div class="col-md-12 mt-3" v-cloak>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{$answersCount. " " . Str::plural('Answer',$answersCount)}}</h3>
                    </div>
                    <hr>
                    @include('layouts._messages')
                    @foreach($answers as $answer)
                        @include('answers._answer')
                    @endforeach
                </div>
                
                
            </div>
        </div>
 @endif

