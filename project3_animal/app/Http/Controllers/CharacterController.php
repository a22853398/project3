<?php

namespace App\Http\Controllers;

use App\Models\character;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //讀取一整個表單，或者多筆資料的列表
        $character = Character::get();
        return response(['data' => $character]);
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
