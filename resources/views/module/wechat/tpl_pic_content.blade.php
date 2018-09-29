<xml>
  <ToUserName><![CDATA[{{$ToUserName}}]]></ToUserName>
  <FromUserName><![CDATA[{{$FromUserName}}]]></FromUserName>
  <CreateTime>{{$CreateTime}}</CreateTime>
  <MsgType><![CDATA[news]]></MsgType>
  <ArticleCount>{{ count($vars['news']) }}</ArticleCount>
  <Articles>
  @foreach ($news  as $k => $v)
    <item>
    <Title><![CDATA[{{$v['Title']}}]]></Title>
    <Description><![CDATA[{{$v['Description']}}]]></Description>
    <PicUrl><![CDATA[{{$v['PicUrl']}}]]></PicUrl>
    <Url><![CDATA[{{$v['Url']}}]]></Url>
    </item>
  @endforeach
  </Articles>
</xml>