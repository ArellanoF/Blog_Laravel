<div class="comments-content">
    @foreach($comments as $comment)
    <div class="comments-body">
        <span class="comment-head"> &nbsp; &nbsp;{{$comment->user->full_name}} @for($i = 0; $i < $comment->value; $i++)
                ⭐
                @endfor</span>
        <p class="comment-description line">{{$comment->description}}</p>
        <span class="comment-date"><b>Realizado: {{date('d/m/Y H:m:s', strtotime($comment->created_at)) }}</b></span>
    </div>
    <hr>
    @endforeach

    <div class="links-paginate">
{!! $comments->render() !!}
    </div>
</div>