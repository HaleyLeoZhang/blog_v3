<?php
namespace tests\Services;

use App\Jobs\EmailJob;
use App\Services\Tool\FilterService;
use LogService;

class ToolsServiceTest extends \TestCase
{

    public function email()
    {
        $receivers = [
            [
                'addr' =>'myboyli4@163.com' ,
                'name'=> 'SQL备份邮箱',
            ]
        ];
        $title   = '测试';
        $content = '云天河blog_v3，发送邮件测试，时间：' . date('Y-m-d H:i:s');
        $data    = compact('receivers', 'title', 'content');
        $job_obj = new EmailJob(EmailJob::TYPE_SEND_TEXT, json_encode($data));
        $job     = $job_obj->onQueue(EmailJob::QUEUE_NAME);
        dispatch($job);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info');
    }


    public function test_email()
    {
        $after_text = FilterService::xss("adaljdasldja");
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', compact('after_text'));
    }

}
