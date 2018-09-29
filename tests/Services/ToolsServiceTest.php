<?php
namespace tests\Services;

use App\Jobs\EmailJob;
use LogService;

class ToolsServiceTest extends \TestCase
{

    public function test_email()
    {
        $to      = 'myboyli4@163.com';
        $title   = '测试';
        $content = '云天河blog_v3，发送邮件测试，时间：' . date('Y-m-d H:i:s');
        $data    = compact('to', 'title', 'content');
        $job_obj = new EmailJob(EmailJob::TYPE_SEND_TEXT, json_encode($data));
        $job     = $job_obj->onQueue(EmailJob::QUEUE_NAME);
        dispatch($job);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info');
    }

}
