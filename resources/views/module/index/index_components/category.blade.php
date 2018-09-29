
    <div class="categories">
        <div class="right_bar_title">
            <h2><span><i class="fa fa-folder-open-o"></i> 归档分类</span></h2>
        </div>
        <div class="clr"></div>
        @foreach( $cate_list as $item )
        <a href="/?cate_id={{ $item->id }}">
            <div class="one_category">
                <i class="fa fa-tag" aria-hidden="true"></i>
                {{ $item->title }}（{{ $item->total }}）
            </div>
        </a>
        @endforeach
    </div>