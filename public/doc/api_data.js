define({ "api": [
  {
    "type": "post",
    "url": "/admin/login_google",
    "title": "管理员登录-谷歌验证",
    "name": "login_google",
    "group": "Account",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account",
            "description": "<p>用户的帐号：目前暂定为邮箱号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>用户的密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "google_captchar",
            "description": "<p>谷歌验证码</p>"
          }
        ]
      }
    },
    "description": "<p>后台帐号登录（所有参数：先被经过 RSA 公钥加密，后被前端 encodeURIComponent 加密）</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"\",\n    \"data\":\n    {\n        \"quert_string\": \"token_name=End-Token&token_value=9abc3156eb404f72b8a7d9286d01307b&expire_at=1542867765\" // 身份令牌信息\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 10003,\n    \"message\": \"帐号或者密码不正确\",\n    \"data\": null\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 501,\n    \"message\": \"谷歌验证码不正确\",\n    \"data\": null\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 10006,\n    \"message\": \"谷歌验证码未设置\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AccountController.php",
    "groupTitle": "Account"
  },
  {
    "type": "post",
    "url": "/admin/login_slide_verify",
    "title": "管理员登录-滑块验证",
    "name": "login_slide_verify",
    "group": "Account",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account",
            "description": "<p>用户的帐号：目前暂定为邮箱号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>用户的密码</p>"
          }
        ]
      }
    },
    "description": "<p>后台帐号登录（所有参数：先被经过 RSA 公钥加密，后被前端 encodeURIComponent 加密）</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"\",\n    \"data\":\n    {\n        \"quert_string\": \"token_name=End-Token&token_value=9abc3156eb404f72b8a7d9286d01307b&expire_at=1542867765\" // 身份令牌信息\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 10003,\n    \"message\": \"帐号或者密码不正确\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AccountController.php",
    "groupTitle": "Account"
  },
  {
    "type": "post",
    "url": "/api/behaviour/foot_mark",
    "title": "游客访问足迹",
    "name": "foot_mark",
    "group": "Behaviour",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>访问地址</p>"
          }
        ]
      }
    },
    "description": "<p>记录人们访问过的页面足迹，并进行相应数据分析</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/BehaviourController.php",
    "groupTitle": "Behaviour"
  },
  {
    "type": "post",
    "url": "/api/comic/pic_list",
    "title": "漫画图片 - 每话图片列表",
    "name": "pic_list",
    "group": "Comic",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "comic_id",
            "description": "<p>动漫ID，如，1表示《一人之下》</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>第多少话，如，1表示第一话</p>"
          }
        ]
      }
    },
    "description": "<p>如，爬取的《一人之下》这漫画的相关资源，已经被转存到第三方图床，</p> <p>每话的地址都会从这里传出去，前端按顺序显示图片即可</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"pic_list\": [\n        {\n            \"src\": \"https:\\/\\/i.loli.net\\/2018\\/11\\/30\\/5c0123b635b04.jpg\"\n        },\n        {\n            \"src\": \"https:\\/\\/i.loli.net\\/2018\\/11\\/30\\/5c0123d5ebeaf.jpg\"\n        }]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 501,\n    \"message\": \"暂无资源\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/ComicController.php",
    "groupTitle": "Comic"
  },
  {
    "type": "get",
    "url": "/api/comment/info",
    "title": "回复列表",
    "name": "info",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "parent_id",
            "description": "<p>主楼ID，0&gt;是已是主楼</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "location",
            "description": "<p>x&lt;0表示其他位置,x==0表示留言板，x&gt;0其他表示文章ID</p>"
          }
        ]
      }
    },
    "description": "<p>用户评论的列表信息</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"info\": [\n        {\n            \"id\": 17,\n            \"time\": \"2018-03-26 16:22:24\",\n            \"content\": \"ლ(′◉❥◉｀ლ)\",\n            \"name\": \"Itaustin Inc.\",\n            \"type\": 2,\n            \"pic\": \"http:\\/\\/thirdqq.qlogo.cn\\/qqapp\\/101309589\\/9CDCBEF210CA8ADDEBB4C2A33EBBA2D4\\/100\"\n        },\n        {\n            \"id\": 16,\n            \"time\": \"2017-11-16 15:41:09\",\n            \"content\": \"云神\",\n            \"name\": \"Naturo\",\n            \"type\": 2,\n            \"pic\": \"http:\\/\\/thirdqq.qlogo.cn\\/qqapp\\/101309589\\/7FF6D43C9DCF71A26D253174AE9E696F\\/100\"\n        }],\n        \"render\": \"\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "post",
    "url": "/api/comment/reply_add",
    "title": "回复信息",
    "name": "reply_add",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "parent_id",
            "description": "<p>主楼ID，0&gt;是已是主楼</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "content",
            "description": "<p>回复内容</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "location",
            "description": "<p>x&lt;0表示其他位置,x==0表示留言板，x&gt;0其他表示文章ID</p>"
          }
        ]
      }
    },
    "description": "<p>用户评论的列表信息</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"id\": 50\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "get",
    "url": "/api/general/express_delivery",
    "title": "快递查询",
    "name": "express_delivery",
    "group": "ExpressDelivery",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tracking_number",
            "description": "<p>快递单号</p>"
          }
        ]
      }
    },
    "description": "<p>快递查询</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"track_info\": [\n        {\n            \"time\": \"2018-10-17 00:54:46\",\n            \"ftime\": \"2018-10-17 00:54:46\",\n            \"context\": \"【佛山市】 快件离开 【佛山中心】 发往 【北京】\",\n            \"location\": \"佛山中心\"\n        },\n        {\n            \"time\": \"2018-10-17 00:52:23\",\n            \"ftime\": \"2018-10-17 00:52:23\",\n            \"context\": \"【佛山市】 快件到达 【佛山中心】\",\n            \"location\": \"佛山中心\"\n        },\n        {\n            \"time\": \"2018-10-16 21:10:31\",\n            \"ftime\": \"2018-10-16 21:10:31\",\n            \"context\": \"【广州市】 快件离开 【番禺新大石】 发往 【北京】\",\n            \"location\": \"番禺新大石\"\n        },\n        {\n            \"time\": \"2018-10-16 15:08:53\",\n            \"ftime\": \"2018-10-16 15:08:53\",\n            \"context\": \"【广州市】 【番禺新大石】（020-31063349、020-31065201、020-39292257） 的 客户曼曼 （13222222222） 已揽收\",\n            \"location\": \"番禺新大石\"\n        }]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/GeneralController.php",
    "groupTitle": "ExpressDelivery"
  },
  {
    "type": "get",
    "url": "/api/general/memorabilia_bg",
    "title": "大事记 - 背景音乐",
    "name": "kugou_music",
    "group": "Media",
    "description": "<p>大事记 - 背景音乐接口，获取酷狗对应音乐的播放地址</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"url\": \"http:\\/\\/fs.w.kugou.com\\/201809291650\\/b16704e072bc4b64d73c2274b2e406b3\\/G087\\/M06\\/01\\/05\\/94YBAFiHguyALcJ1ADJXXPiRjh8038.mp3\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/GeneralController.php",
    "groupTitle": "Media"
  },
  {
    "type": "get",
    "url": "/api/slide_verify/captchar",
    "title": "获取动态加载的验证码图片",
    "name": "captchar",
    "group": "SlideVerify",
    "description": "<p>该html里面有待验证的base64数据的图片</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\nhtml字符串",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SlideVerifyController.php",
    "groupTitle": "SlideVerify"
  },
  {
    "type": "post",
    "url": "/api/slide_verify/check",
    "title": "验证码，校验",
    "name": "check",
    "group": "SlideVerify",
    "description": "<p>因为前端js对不同语言、情景提示的输出，与后端成套，所以保留历史接口</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": false,\n    \"Err\": 2000,\n    \"out\": \"验证码通过\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SlideVerifyController.php",
    "groupTitle": "SlideVerify"
  },
  {
    "type": "get",
    "url": "/api/slide_verify/init",
    "title": "初始验证码页面",
    "name": "init",
    "group": "SlideVerify",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n初始验证码页面的html",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SlideVerifyController.php",
    "groupTitle": "SlideVerify"
  },
  {
    "type": "get",
    "url": "/api/spa/article_detail",
    "title": "获取文章详情",
    "name": "article_detail",
    "group": "Spa",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "article_id",
            "description": "<p>文章ID</p>"
          }
        ]
      }
    },
    "description": "<p>SPA 获取某篇文章详情</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"article\":\n        {\n            \"id\": 11,\n            \"title\": \"微信开发，快速入门\", // 标题\n            \"type\": 0, // 文本类型，0->markdown,1->富文本\n            \"original\": 0, // 是否原创：1->是 0->不是\n            \"content\": \"<h2>开发前提<\\/h2>\\n\\n<h6>先申请一个公众号中的订阅号，然后...\", // 文章详细内容\n            \"cate_id\": 5, // 分类ID\n            \"statistic\": 2076, // 阅读量\n            \"updated_at\": \"2018-09-13 15:48:44\", // 最后更新时间，后续可能会用到\n            \"created_at\": \"2018-08-05 15:17:41\", // 创建时间\n            \"cate_name\": \"PHP\", // 分类名\n            \"bg_url\": \"http:\\/\\/img.cdn.hlzblog.top\\/17-8-13\\/64417605.jpg\" // 背景图地址\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SpaController.php",
    "groupTitle": "Spa"
  },
  {
    "type": "get",
    "url": "/api/spa/article_list",
    "title": "分页获取文章列表",
    "name": "article_list",
    "group": "Spa",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "to_page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "search",
            "description": "<p>选填，搜索关键词</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cate_id",
            "description": "<p>选填，分类ID</p>"
          }
        ]
      }
    },
    "description": "<p>SPA 分页获取文章列表</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"articles\":\n        {\n            \"info\": [\n            {\n                \"id\": 51,\n                \"title\": \"Vue2.0进阶回顾随笔（一）\",\n                \"descript\": \"书写Vue时候的一些规范、使用细节、Vuex理解等\",\n                \"cate_id\": 4,\n                \"sticky\": 0,\n                \"cover_url\": \"http:\\/\\/img.cdn.hlzblog.top\\/17-6-18\\/35121526.jpg\",\n                \"statistic\": 262,\n                \"created_at\": \"2018-08-05 15:17:41\",\n                \"cate_name\": \"Javascript\"\n            },\n            {\n                \"id\": 50,\n                \"title\": \"Vue2.0进阶规划\",\n                \"descript\": \"云天河对Vue2.0深入进阶规划，以及认为这期间需要了解的一些内容\",\n                \"cate_id\": 4,\n                \"sticky\": 0,\n                \"cover_url\": \"http:\\/\\/img.cdn.hlzblog.top\\/17-6-18\\/35121526.jpg\",\n                \"statistic\": 341,\n                \"created_at\": \"2018-08-05 15:17:41\",\n                \"cate_name\": \"Javascript\"\n            }],\n            \"page_count\": 5,\n            \"total\": 48\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SpaController.php",
    "groupTitle": "Spa"
  },
  {
    "type": "get",
    "url": "/api/spa/category_list",
    "title": "获取分类列表",
    "name": "category_list",
    "group": "Spa",
    "description": "<p>SPA 一次性获取全部分类信息</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"categories\": [\n        {\n            \"id\": 17, // 分类ID\n            \"title\": \"HTTP\", // 分类名\n            \"total\": 6 // 包含文章数\n        },\n        {\n            \"id\": 19,\n            \"title\": \"JAVA\",\n            \"total\": 4\n        },\n        {\n            \"id\": 4,\n            \"title\": \"Javascript\",\n            \"total\": 11\n        },]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/SpaController.php",
    "groupTitle": "Spa"
  },
  {
    "type": "get",
    "url": "/api/article/article_check_line",
    "title": "博文上下线",
    "name": "article_check_line",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>文章id</p>"
          }
        ]
      }
    },
    "description": "<p>修改前，查看对应文章相关内容</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/article/background/background_add",
    "title": "背景主题：修改",
    "name": "background_add",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>图片地址</p>"
          }
        ]
      }
    },
    "description": "<p>修改背景主题</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/article/background/background_add",
    "title": "背景主题：添加",
    "name": "background_add",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>图片地址</p>"
          }
        ]
      }
    },
    "description": "<p>添加背景主题</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/article/background/background_del",
    "title": "背景主题：删除",
    "name": "background_del",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键</p>"
          }
        ]
      }
    },
    "description": "<p>删除某个背景主题</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "get",
    "url": "/article/article/background_info",
    "title": "背景主题：分页查看",
    "name": "background_info",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "to_page",
            "description": "<p>页码，默认值为1</p>"
          }
        ]
      }
    },
    "description": "<p>获取背景主题数据</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"info\": [\n        {\n            \"id\": 35,\n            \"url\": \"http:\\/\\/img.cdn.hlzblog.top\\/18-2-7\\/74292535.jpg\",\n            \"is_deleted\": 0,\n            \"updated_at\": \"2018-08-05 15:13:34\",\n            \"created_at\": \"0000-00-00 00:00:00\"\n        },\n        {\n            \"id\": 33,\n            \"url\": \"http:\\/\\/img.cdn.hlzblog.top\\/18-2-7\\/53540060.jpg\",\n            \"is_deleted\": 0,\n            \"updated_at\": \"2018-08-05 15:13:34\",\n            \"created_at\": \"0000-00-00 00:00:00\"\n        }],\n        \"page_count\": 3,\n        \"total\": 26\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/admin/article/category_add",
    "title": "博文分类：添加",
    "name": "category_add",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>分类名</p>"
          }
        ]
      }
    },
    "description": "<p>添加博文</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/admin/article/category_del",
    "title": "博文分类：删除",
    "name": "category_del",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键</p>"
          }
        ]
      }
    },
    "description": "<p>删除对应分类名</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/admin/article/category_edit",
    "title": "博文分类：修改",
    "name": "category_edit",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>分类名</p>"
          }
        ]
      }
    },
    "description": "<p>修改对应分类名</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "get",
    "url": "/admin/article/category_info",
    "title": "博文分类：查看",
    "name": "category_info",
    "group": "article",
    "description": "<p>查看所有分类</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\":\n    {\n        \"info\": [\n        {\n            \"id\": 36,\n            \"title\": \"111\",\n            \"is_deleted\": 0,\n            \"updated_at\": \"2018-09-22 02:36:27\",\n            \"created_at\": \"2018-09-22 02:36:27\"\n        },\n        {\n            \"id\": 23,\n            \"title\": \"Golang\",\n            \"is_deleted\": 0,\n            \"updated_at\": \"2018-08-05 15:16:22\",\n            \"created_at\": \"2018-08-05 15:16:22\"\n        }]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/api/article/detail_create",
    "title": "博文内容：添加",
    "name": "detail_create",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cate_id",
            "description": "<p>对应文章分类</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cover_url",
            "description": "<p>封面图片url</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "descript",
            "description": "<p>文章概述</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>文本类型 0=&gt;Markdown 1=&gt;Editor</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "raw_content",
            "description": "<p>未转为html之前的文章内容</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sticky",
            "description": "<p>置顶项[0=&gt;未置顶、1=&gt;置顶]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "original",
            "description": "<p>[0=&gt;原创,1=&gt;转载]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bg_id",
            "description": "<p>对应文章背景主题号【0=&gt;没有背景主题】</p>"
          }
        ]
      }
    },
    "description": "<p>添加对应博文</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/api/article/detail_del",
    "title": "博文内容：删除",
    "name": "detail_del",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键</p>"
          }
        ]
      }
    },
    "description": "<p>删除对应博文内容</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/admin/article/detail_edit",
    "title": "博文内容：修改",
    "name": "detail_edit",
    "group": "article",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>文章编号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>文本类型 0=&gt;Markdown 1=&gt;Editor</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sticky",
            "description": "<p>置顶项[0=&gt;未置顶、1=&gt;置顶]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sequence",
            "description": "<p>置顶顺序号（权重），选填</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "original",
            "description": "<p>[0=&gt;原创,1=&gt;转载]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "is_online",
            "description": "<p>[0=&gt;下线,1=&gt;上线]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "raw_content",
            "description": "<p>未转为html之前的文章内容</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "descript",
            "description": "<p>描述</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cover_url",
            "description": "<p>封面图片url</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cate_id",
            "description": "<p>对应文章分类</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bg_id",
            "description": "<p>对应文章背景主题号【0=&gt;没有背景主题】</p>"
          }
        ]
      }
    },
    "description": "<p>添加博文</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Article/ApiController.php",
    "groupTitle": "article"
  },
  {
    "type": "post",
    "url": "/admin/upload/editor",
    "title": "图片上传-editor",
    "name": "editor",
    "group": "upload",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "upfile",
            "description": "<p>待上传的图片</p>"
          }
        ]
      }
    },
    "description": "<p>图片上传-editor</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"state\": \"SUCCESS\",\n    \"url\": \"\\/\\/tencent.cdn.hlzblog.top\\/blog\\/upload\\/img\\/2018_09_29_QLSwfPWw.jpg\",\n    \"title\": \"\\u67e5\\u770b\\u56fe\\u7247\",\n    \"original\": \"-\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Upload/ApiController.php",
    "groupTitle": "upload"
  },
  {
    "type": "post",
    "url": "/admin/upload/markdown",
    "title": "图片上传-markdown",
    "name": "markdown",
    "group": "upload",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "editormd-image-file",
            "description": "<p>待上传的图片</p>"
          }
        ]
      }
    },
    "description": "<p>图片上传-markdown</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"success\": 1,\n    \"url\": \"\\/\\/tencent.cdn.hlzblog.top\\/blog\\/upload\\/img\\/2018_09_29_KAsu7WUa.jpg\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/Upload/ApiController.php",
    "groupTitle": "upload"
  },
  {
    "type": "post",
    "url": "/admin/user/comments_update",
    "title": "更新用户评论",
    "name": "comments_update",
    "group": "user",
    "description": "<p>更新用户评论</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/User/ApiController.php",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/admin/user/hanld_bind_relation",
    "title": "修改与管理员的绑定关系",
    "name": "hanld_bind_relation",
    "group": "user",
    "description": "<p>修改与管理员的绑定关系</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/User/ApiController.php",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/admin/user/user_list_handle",
    "title": "修改用户状态",
    "name": "user_list_handle",
    "group": "user",
    "description": "<p>修改用户状态</p>",
    "version": "3.0.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 200,\n    \"message\": \"请求成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/User/ApiController.php",
    "groupTitle": "user"
  }
] });
