<?php
namespace App\Helpers;

use App\Exceptions\Consts;

// ----------------------------------------------------------------------
// api接口格式化返回值业务类封装
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class Response
{
    /**
     * 不符合预期时，返回
     * @param int code  定义在  App\Exceptions\Consts 中的编号
     * @param string message  临时自定义的消息，选填
     */
    public static function error($code, $message = '')
    {
        if ('' != $message) {
            $msg = $message;
        } else {
            $msg = Consts::$message[$code] ?? 'failed';
        }
        $result = [
            "code"    => $code,
            "message" => $msg,
            "data"    => null,
        ];

        // JSON_UNESCAPED_UNICODE 这个参数可以json不转译unicode值
        // 如果不加默认是输出如 {"hello":"\u4e16\u754c"}
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 成功时，返回
     * @param array|arrayObject data 返回的数据
     * @param string message  临时自定义的消息，选填
     */
    public static function success($data = null, $msg = '')
    {
        if ('' == $msg) {
            $msg = Consts::$message[Consts::SUCCESS];
        }
        $result = [
            "code"    => Consts::SUCCESS,
            "message" => $msg,
            "data"    => $data,
        ];
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
