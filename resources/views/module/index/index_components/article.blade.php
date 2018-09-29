    @if( count($article_list['info']) )

        @foreach($article_list['info'] as $article)  
        <div class="article_list article_animated fadeInUp" add-class=" article_animated fadeInUp">
            <div class="article_title">
                <h1><a href="/article/{{ $article->id }}.html" target="_blank">{{ $article->title }}
                    @if( $article->sticky  )
                    <img src="{{ static_host() }}/static_pc/img/default/sticky.gif" alt="" style="padding-left:5px;">
                    @endif
                </a></h1>
            </div>
            <div class="article_field">
                <div class="left_pic">
                    <a href="/article/{{ $article->id }}.html" target="_blank">
                        <img src="{{ $article->cover_url }}" alt="封面图片" title="查看详情"/>
                    </a>
                </div>
                <div class="right_inner">
                    <div class="others" yth-descript="[都要带图标的]发布时间、阅读量、评论数、所属分类">
                        <span title="发布时间">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            {{ $article->created_at }}
                            <font></font>
                        </span>
                        <span title="所属分类">
                            <i class="fa fa-folder-open-o"></i>
                            <a href="/?cate_id={{ $article->cate_id }}">{{ $article->cate_name }}</a>
                            <font></font>
                        </span>
                        <span title="浏览量">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            {{ $article->statistic }}
                        </span>
                        <div class="clr"></div>
                    </div>
                    <div class="descript">
                        <p>{{ $article->descript }}
                            <a href="/article/{{ $article->id }}.html" target="_blank">
                                More
                            </a>
                        </p>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            
        </div>
        @endforeach
        <div style="padding-left:15px;">
            {!! $article_list['render'] !!}
        </div>

    @else
        <div class="article_list article_animated fadeInUp" add-class=" article_animated fadeInUp">
            @if( isset( $_GET['search'] ) )
                暂无 <b color="#ecb4b4">{{ $_GET['search'] ?? '' }}</b> 的搜索结果   
            @elseif( isset($_GET['cate_id']) )
                暂无 该分类 的搜索结果   
            @endif
                     
        </div>
    @endif
