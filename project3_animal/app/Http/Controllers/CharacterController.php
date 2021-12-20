<?php

namespace App\Http\Controllers;

use App\Models\character;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;//Response要用這個
use Illuminate\Support\Facades\Cache;//建立快取要引用的


class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        //讀取一整個表單，或者多筆資料的列表
        //$character = Character::get();
        //return response(['data' => $character]);
        */
        
        /*
        //但因為如果資料超過100/1000甚至更多，要撈資料會更麻煩
        //所以要設定每次都多少的限制，避免撈太多資料造成伺服器崩潰
        $limit = $request->limit ?? 10;//沒有值的話預設10
        //使用orderBy，表示SQL語法我要ORDER BY
        $character = character::orderBy("id", "asc")
            ->paginate($limit)//使用分頁
            ->appends($request->query());
        ;
        return response($character, Response::HTTP_OK);
        */

        /*
        // 可以自訂查詢條件的查詢寫法，主要應用laravel內建的函式，就像是寫那個一樣，SQL語法 
        $limit = $request->limit ?? 10;//設定得到的結果的上限
        
        //查詢建構器，分段的方式撰寫SQL語句
        $query = character::query();
        if(isset($request->filters)){
            $filters = explode(",", $request->fileters);
            //把條件切開，php?a=XXX&b=XXX之類的
            //還有像這樣 query/XX/1/key/XX/XX/XXX/XXXXXXXX/XX/XXX/XXX之類的
            //laravel的查詢GET大概長得像這樣 /XXX?filters=XXX:OOXX,OOO:XXOO 用,做複數的變數傳遞
            foreach ($filters as $key => $filter){
                list($key, $value) = explode(":", $filter);//PHP內建方法，定義$key和$value兩個變數，name:黑,personality:安安
                //所以會變成$key = "name", $value = "黑" 這樣
                $query->where($key, 'like', "%$value%");
            }

            $character = $query->orderBy("id", "desc")
                ->paginate($limit)
                ->appends($request->query());

                return response($character, Response::HTTP_OK);
        }
        */

        /**建立查詢結果快取 */
        //取得網址及後面的參數
        $url = $request->url();
        $queryParams = $request->query();//網址後面?的參數們
        ksort($queryParams);//參數第一個字排序
        $queryString = http_build_query($queryParams);//將查詢參數轉為字串
        $fullUrl = "{$url}?{$queryString}";//組合成完整網址

        //使用 Laravel 的快取方法檢查是否有快取紀錄
        if(Cache::has($fullUrl)){
            return Cache::get($fullUrl);//如果有快取，直接回傳快取
        }

        //設定資料初始上限
        $limit = $request->limit ?? 10;

        //建立查詢建構器，分段撰寫SQL
        $query = character::query();

        //篩選程式邏輯，如果有設定filters參數
        if(isset($request->filters)){
            $filters = explode(',', $request->filters);
            foreach($filters as $key => $filter){
                list($key, $value) = explode(':', $filter);
                $query->where($key, 'like', "%$value%");
            }
        }

        //排序
        if(isset($request->sorts)){
            $sorts = explode(',', $request->sorts);
            foreach($sorts as $key => $sort){
                list($key, $value) = explode(':', $sort);
                if($value == 'asc' || $value == 'desc'){
                    $query->orderBy($key, $value);
                }
            }
        }else{
            //沒有條件的話，預設id大小排序
            $query->orderBy('id', 'desc');
        }

        $character = $query->paginate($limit)->appends($request->query());

        //沒有快取記住資料，設定60秒過期，快取名稱使用網址命名
        return Cache::remember($fullUrl, 60, function () use ($character){
            return response($character, Response::HTTP_OK);
        });


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //新增全新的資料
        $character = Character::create($request->all());
        $character = $character->refresh();
        return response($character, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(character $character)
    {
        //讀取單一個資料
        return response($character, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, character $character)
    {
        //更新的方法
        $character->update($request->all());
        return response($character, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(character $character)
    {
        //刪除的方法
        $character->delete();//變數的名稱必須與api.php裡面的Route定義的相同，不然會刪不掉
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
