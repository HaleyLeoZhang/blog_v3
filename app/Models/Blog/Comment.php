<?php
namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

// 博客内的评论

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content', // 评论内容
        'parent_id', // 评论父类ID，0表示主楼，其他表示子楼
        'user_id', // 用户ID
        'location', // x<0 表示其他位置, x==0 表示留言板，x>0 其他表示文章ID
        'status', // 评论显示状态：1->可用，2->冻结
        'is_deleted', // 软删除，1->已删除
    ];

    // ---- 全部类型 ----
    const SHOW_ALL = -200; // 显示全部内容

    // ---------------------- 删除状态 ----------------------

    const IS_DELETED_NO  = 0; // 未删除
    const IS_DELETED_YES = 1; // 已删除

    public static $list_delete = [
        self::IS_DELETED_NO,
        self::IS_DELETED_YES,
    ];

    public static $text_delete = [
        self::IS_DELETED_NO  => '正常',
        self::IS_DELETED_YES => '已删除',
    ];

    // ---------------------- 评论状态 ----------------------

    const STATUS_NORMAL = 1; // 可用
    const STATUS_LOCK   = 2; // 冻结

    public static $message_status = [
        self::SHOW_ALL      => '---全部---',
        self::STATUS_NORMAL => '可用',
        self::STATUS_LOCK   => '冻结',
    ];

    /**
     * 文章位置、评论位置链接
     * @return array
     */
    public function comment_type()
    {
        switch (true) {
            case $this->location > 0:
                $type_name = $this->title;
                $link = "/article/{$this->location}.html#nav";
                $color = '#009688';
                break;
            case $this->location == 0:
                $type_name = '留言板';
                $link = '/board';
                $color = '#71C671';
                break;
            default:
                $type_name = '-';
                $link = '-';
                $color = '#2b2b2b';
        }
        return [
            $type_name,
            $link,
            $color,
        ];
    }


    /**
     * 后台查看 `评论位置` 配色方案
     * @return string
     */
    public function get_title_src(){
        list($type_name, $link, $color) = $this->comment_type();
        $get_title_src = '
            <a href="'. $link .'" target="_blank" style="font-weight: 600;color: #009688;">
                <font color="'. $color .'">'.$type_name.'</font>
            </a>
        ';
        return $get_title_src;
    }

}
