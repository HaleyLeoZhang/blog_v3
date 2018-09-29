<?php

namespace App\Exceptions;

use ApiException;
use App\Helpers\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        NotFoundHttpException::class,
        ApiException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $exception_code    = $exception->getCode();
        $exception_message = $exception->getMessage();

        // 传入参数异常
        if ($exception instanceof ValidationException) {
            return Response::error(\Consts::VALIDATE_PARAMS, $exception_message);
        }

        // API正常抛错
        if ($exception instanceof ApiException) {
            return Response::error($exception_code, $exception_message);
        }

        $is_debug = env('APP_DEBUG', false); // 开发阶段，直接报到本地，上线后，直接上报到 Sentry

        if ($is_debug) {
            \Log::info($exception);
            return parent::render($request, $exception);
        } else {
            // - 页面找不到
            if ($exception instanceof NotFoundHttpException) {
                return redirect('/404.html');
            }
            // - 其他错误，统一抛出异常
            return Response::error(\Consts::FAILED_INNER);
        }

    }
}
