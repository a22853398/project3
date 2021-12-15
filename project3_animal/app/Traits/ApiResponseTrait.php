<?php
namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * 統一定義錯誤及例外的回應方法
     * @param mixed $msg
     * @param mixed $status
     * @param mixed|null $code
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($msg, $status, $code=null){
        $code = $code ?? $status;//code為null時，設定status為code的值

        return response()->json(
            [
                "message" => $msg,
                "code" => $code
            ],
            $status
        );
    }
}

