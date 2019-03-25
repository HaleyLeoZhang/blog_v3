<xml>
  <ToUserName><![CDATA[{!!$ToUserName!!}]]></ToUserName>
  <FromUserName><![CDATA[!!$FromUserName!!}]]></FromUserName>
  <CreateTime>{!!$CreateTime!!}</CreateTime>
  <MsgType><![CDATA[news]]></MsgType>
  <ArticleCount>{!! count($news) !!}</ArticleCount>
  <Articles>
    @foreach ($news as $index => $one)
    <item>
      <Title><![CDATA[{!!$one['Title']!!}]]></Title>
      <Description><![CDATA[{!!$one['Description']!!}]]></Description>
      <PicUrl><![CDATA[{!!$one['PicUrl']!!}]]></PicUrl>
      <Url><![CDATA[{!!$one['Url']!!}]]></Url>
    </item>
  @endforeach
  </Articles>
</xml>