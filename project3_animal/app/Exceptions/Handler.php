<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

//引用自訂特徵，丟錯誤的
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    //引用特徵
    use ApiResponseTrait;
    /**
     * 自訂異常錯誤處理
     */
    public function render($request, Throwable $e)
    {
        /* 舊版
        if($request->expectsJson()){
            if($e instanceof ModelNotFoundException){
                return response()->json(
                    [
                        "Error" => "找不到目標無法刪除",
                    ]
                );
            }
        }
        return parent::render($request, $e);
        */

        /* 引用特徵的新版 */
        if($request->expectsJson()){
            //1. Model找不到，沒有該ID的檔案
            if($e instanceof ModelNotFoundException){
                return $this->errorResponse("找不到檔案", Response::HTTP_NOT_FOUND);
            }
            //2. 網址錯誤，ID打錯
            if($e instanceof NotFoundHttpException){
                return $this->errorResponse("無法找到網址", Response::HTTP_NOT_FOUND);
            }
            //3.網址不允許request動詞
            if($e instanceof MethodNotAllowedException){
                return $this->errorResponse("不允許此請求方法".$e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
            }
        }
        
    }   
}
