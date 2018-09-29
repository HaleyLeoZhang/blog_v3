<div class="recommands">
    <div class="right_bar_title">
        <h2><span>火热文章</span></h2>
    </div>
    @foreach($hot_articles as $item)
    <div class="one_recommand">
        <a href="/article/{{ $item->id }}.html" target="_blank" title="{{ $item->title }}">
                {{ $item->title }}
            </a>
        <div class="clr"></div>
    </div>
    @endforeach
</div>