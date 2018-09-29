<div class="assignments">
    <div class="right_bar_title">
        <h2><span>最新评论</span></h2>
    </div>
    @foreach($lastest_comments as $item)
    <a href="{{ $item->comment_type()[1] }}" target="_blank">
        <div class="one_assignment" title="查看对应文章">
            <img src="{{ $item->pic }}" alt="">
            <div class="say">
                <span>@ {{ $item->name }}</span>
                <font>说：</font>
                <p title="{{ $item->content }}">
                    {{ $item->content }}
                </p>
            </div>
            <div class="clr"></div>
        </div>
    </a>
   @endforeach
</div>