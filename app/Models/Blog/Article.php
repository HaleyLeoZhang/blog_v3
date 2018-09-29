<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

// 图片上传日志

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title', // 标题
        'type', // 文本类型，markdown、富文本
        'sticky', // 是否置顶
        'sequence', // 置顶的顺序号：同一顺序，ID小的会被置顶
        'original', // 是否原创：1->是 0->不是
        'is_online', // 是否上线，1->已上线
        'raw_content', // 处理前数据
        'descript', // 描述
        'cover_url', // 封面图片链接
        'cate_id', // 类别ID，关联 article_categorys.id
        'bg_id', // 背景图ID，关联background_lists.id
        'content', // 处理后数据
        'statistic', // 用户浏览数
        'is_deleted', // 软删除，1->已删除
    ];

    const DEFAULT_ARTICLE_FOR_CREATE = 0; // 文章ID为0，专门用于创建文章

    // ---- 全部类型 ----
    const SHOW_ALL = -200; // 显示全部内容

    // ---------------------- 资源类型 ----------------------

    const IS_ORIGINAL_NO  = 0; // 转载
    const IS_ORIGINAL_YES = 1; // 原创

    public static $list_original = [
        self::SHOW_ALL,
        self::IS_ORIGINAL_NO,
        self::IS_ORIGINAL_YES,
    ];

    public static $text_original = [
        self::SHOW_ALL        => '---全部---',
        self::IS_ORIGINAL_NO  => '转载',
        self::IS_ORIGINAL_YES => '原创',
    ];

    // ---------------------- 编辑类型 ----------------------

    const EDIT_TYPE_MARKDOWN = 0; // Markdown
    const EDIT_TYPE_EDITOR   = 1; // 富文本

    public static $list_edit_type = [
        self::SHOW_ALL,
        self::EDIT_TYPE_MARKDOWN,
        self::EDIT_TYPE_EDITOR,
    ];

    public static $text_edit_type = [
        self::SHOW_ALL           => '---全部---',
        self::EDIT_TYPE_MARKDOWN => 'Markdown',
        self::EDIT_TYPE_EDITOR   => '富文本',
    ];

    // ---------------------- 置顶状态 ----------------------

    const IS_STICKY_NO  = 0; // 未置顶
    const IS_STICKY_YES = 1; // 已置顶

    public static $list_sticky = [
        self::SHOW_ALL,
        self::IS_STICKY_NO,
        self::IS_STICKY_YES,
    ];

    public static $text_sticky = [
        self::SHOW_ALL      => '---全部---',
        self::IS_STICKY_NO  => '未置顶',
        self::IS_STICKY_YES => '已置顶',
    ];

    // ---------------------- 上线状态 ----------------------

    const IS_ONLINE_NO  = 0; // 未上线
    const IS_ONLINE_YES = 1; // 已上线

    public static $list_online = [
        self::SHOW_ALL,
        self::IS_ONLINE_NO,
        self::IS_ONLINE_YES,
    ];

    public static $text_online = [
        self::SHOW_ALL      => '---全部---',
        self::IS_ONLINE_NO  => '下线',
        self::IS_ONLINE_YES => '已上线',
    ];

    // ---------------------- 删除状态 ----------------------

    const IS_DELETED_NO  = 0; // 未删除
    const IS_DELETED_YES = 1; // 已删除

    public static $list_delete = [
        self::IS_DELETED_NO,
        self::IS_DELETED_YES,
    ];

    public static $text_delete = [
        self::IS_DELETED_NO  => '未删除',
        self::IS_DELETED_YES => '已删除',
    ];

}
