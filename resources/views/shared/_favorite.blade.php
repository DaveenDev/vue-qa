<a title="Click to mark as favorite question (click again to undo)" 
onclick="event.preventDefault(); document.getElementById('fav-question-{{$model->id}}').submit();"
class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
>
<i class="fa fa-star fa-2x"></i>
<span class="favorites-count">{{$model->favorites_count}}</span>

</a>
<form id="fav-question-{{$model->id}}" method="Post" action="/questions/{{$model->id}}/favorites" style="display: none">
@csrf
@if($model->is_Favorited)
    @method('Delete')
@endif  
</form>