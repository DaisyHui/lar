<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function getBasetest(Request $request)
    {
        $input = $request->input('test');
        echo $input;
    }
    
    public function getMethod(Request $request){
        //非get请求不能访问
        if(!$request->isMethod('get')){
            abort(404);
        }
        $method = $request->method();
        echo $method;
    }
    
    public function getLastRequest(Request $request){
        //$request->flash();
        return redirect('/request/current-request')->withInput();
    }
    
    public function getCurrentRequest(Request $request){
        $lastRequestData = $request->old();
        dd($lastRequestData);
        echo '<pre>';
        print_r($lastRequestData);
    }
    
    public function getCookie(Request $request){
        $cookies = $request->cookie();
        dd($cookies);
    }
    
    public function getFileupload()
    {
        $postUrl = '/request/fileupload';
        $csrf_field = csrf_field();
        $html = <<<CREATE
        <form action="$postUrl" method="POST" enctype="multipart/form-data">
        $csrf_field
        <input type="file" name="file"><br/><br/>
        <input type="submit" value="提交"/>
        </form>
CREATE;
        return $html;
    }
    
    //文件上传处理
    public function postFileupload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $destPath = realpath(public_path('images'));
        if(!file_exists($destPath))
            mkdir($destPath,0755,true);
        $filename = $file->getClientOriginalName();
        if(!$file->move($destPath,$filename)){
            exit('保存文件失败！');
        }
        exit('文件上传成功！');
    }
    
}