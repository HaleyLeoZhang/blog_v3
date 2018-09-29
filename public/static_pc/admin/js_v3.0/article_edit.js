(function (jq, window, undefined) {
    'use strict';

    function Article() {
        this._sub_form = {}; // 提交的数据
        this.markdown_editor = null; // 实例化的 markdown 编辑器
    }
    // @listen：背景图分页
    Article.prototype.radio_bg = function () {
        // 初始化，添加界面 => 背景列表
        yth_pageination({
            "api": admin_api("article", "background_info"),
            "render_tpl": "bg_tpl",
            "render_html": "bg_html",
            "pageination_id": "bg_html_pagenation",
            "loading_switch": true,
            "callback": function () {
                $(".bg_id_radio").unbind();
                $(".bg_id_radio").on("click", function () {
                    var bg_id = this.dataset.id;
                    $("#bg_id").val(bg_id);
                });
            },
        });
    };
    // @listen：封面图变化
    Article.prototype.cover_url_preview = function () {
        jq("#cover_url").on("keyup paste", function () {
            var src = this.value;
            $("#cover_url_preview").attr("src", src);
        });
    };
    // @listen：编辑器切换
    Article.prototype.change_editor = function () {
        jq(".radio_edit_type").on('click', function () {
            var current_type = parseInt( this.dataset.id );
            var another = (current_type + 1) % 2;
            var _show = '#editor_' + current_type;
            var _hide = '#editor_' + another;
            $(_show).show();
            $(_hide).hide();
        });
    };
    // @listen：提交数据
    Article.prototype.submit_form = function () {
        var _this = this;
        jq(".sub_form").on('click', function () {
            _this.get_edit_info();
            console.log(_this._sub_form);
            var init = {
                "title": "确认更新吗？",
                "api_url": admin_api('article', 'detail_edit'),
                "data": _this._sub_form,
                "res_text": "更新成功",
            };
            if( "0" == _this._sub_form.id ){
                init.title = "确认添加吗？";
                init.res_text = "创建成功";
                init.api_url = admin_api('article', 'detail_create');
            }
            confirm_ajax(init);
        });
    };
    // @action：初始化编辑器
    Article.prototype.initial_editor = function () {
        editor();
        this.markdown_editor = markdown_editor();
    };
    // @action:获取最新编辑内容
    Article.prototype.get_edit_info = function () {
        var this_form = document.forms.article_edit;
        // 依据选择的文本类型，获取文章内容
        var article_content = '';
        if( 0 == this_form.edit_type.value ){
            article_content = this.markdown_editor.getMarkdown();
        }
        else if(1 == this_form.edit_type.value){
            article_content = editor(true);
        }
        var _sub_form = {
            'id'         : this_form.title.dataset.article_id,
            'title'      : this_form.title.value,
            'type'       : this_form.edit_type.value,
            'sticky'     : this_form.sticky.value,
            'sequence'   : this_form.sequence.value,
            'original'   : this_form.original.value,
            'is_online'  : this_form.online.value,
            'raw_content': article_content,
            'descript'   : this_form.descript.value,
            'cover_url'   : this_form.cover_url.value,
            'cate_id'   : this_form.cate_id.value,
            'bg_id'   : this_form.bg_id.value,
        };
        this._sub_form = _sub_form;
    };
    // @action：初始化所有需要的功能
    Article.prototype.initial = function () {
        this.radio_bg();
        this.cover_url_preview();
        this.change_editor();
        this.initial_editor();
        this.submit_form();
    };

    var article = new Article();
    article.initial();



})(jQuery, window);