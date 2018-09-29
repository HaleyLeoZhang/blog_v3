<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Location;
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Jobs\AnalysisVisitorJob;
use Illuminate\Http\Request;

class BehaviourController extends BaseController
{

    /**
     * @api {post} /api/behaviour/foot_mark 游客访问足迹
     * @apiName foot_mark
     * @apiGroup Behaviour
     *
     * @apiParam {string} url 访问地址
     *
     * @apiDescription  记录人们访问过的页面足迹，并进行相应数据分析
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     */
    public function foot_mark(Request $request)
    {
        $filter = [
            'url' => 'required',
        ];
        $this->validate($request, $filter);
        $url               = $request->input('url');
        $header            = json_encode($request->header());
        $payload           = [];
        $payload['ip']     = Location::get_ip();
        $payload['header'] = $header;
        $payload['url']    = $url;
        $job               = (new AnalysisVisitorJob(
            AnalysisVisitorJob::ACTION_LOCATION_ANALYSIS, json_encode($payload)
        ))->onQueue(AnalysisVisitorJob::QUEUE_NAME);
        dispatch($job);
        return Response::success();
    }

}
