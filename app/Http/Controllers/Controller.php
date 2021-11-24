<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *      version=APP_VERSION,
 *      title="TestProject API Documentation",
 *      description="회원정보 조회, 주문정보 조회 페이지",
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="회원정보 조회, 주문정보 조회 서버"
 * )
 * @OA\Tag(
 *     name="User",
 *     description="회원 정보"
 * )
 * @OA\Tag(
 *     name="Order",
 *     description="주문 정보"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** 일괄 예외처리를 위한 프로세스
     * @param $closure

     */
    protected function process($closure){

        try{
            $res = $closure();
            return $res;
        }
        catch(ModelNotFoundException $e){
            $response = [
                'code'=>'1',
                'msg'=>'not found '.$e->getModel().' Data',
                'request'=>request()->all()
            ];

            Log::error('not found '.$e->getModel().' Data', [
                'request'=>request()->all(),
                'error' => $e->getTrace()
            ]);

            return response($response, 404);
        }
        catch(\Throwable $e){
            $response = [
                'code'=>'-1',
                'msg'=>$e->getMessage(),
                'request'=>request()->all()
            ];

            Log::error($e->getMessage(), [
                'request'=>request()->all(),
                'error' => $e->getTrace()
            ]);

            return response($response, 500);
        }
    }
}
