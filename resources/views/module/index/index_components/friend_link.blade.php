
            <div class="friend_link">
                <div class="title">友情链接</div>
                <div class="link_list">
                    <p>
                        @foreach ($friend_links as $item)
                        <em>
                            <a href="{{ $item->href }}" target="_blank">{{ $item->title }}</a>
                            <font>|</font>
                        </em>
                        @endforeach
                    </p>
                </div>
            </div>