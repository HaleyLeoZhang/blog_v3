<?php
namespace App\Exceptions;

use App\Exceptions\Consts;
use Exception;

// ----------------------------------------------------------------------
// Api异常抛出
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ApiException extends Exception
{

    public function __construct($message = '', $code = null)
    {
        // - 不写默认 code 时
        if (is_null($code)) {
            $code = Consts::FAILED;
        } else {
            $message = Consts::$message[$code];
        }
        parent::__construct($message, $code);
    }
}
