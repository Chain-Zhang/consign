<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/12
 * Time: 下午10:19
 */
namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Models\ConsignResult;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $postList = Post::all();
        return response()->json($postList);
    }

    public function getPosts(){
        $postList = Post::where('orderby','>',0)->orderby('orderby')->get();
        return response()->json($postList);
    }

    public function add(Request $request){
        $cr = new ConsignResult();
        $name = $request->input('name', '');
        $orderby = $request->input('orderby', '');
        if($name == '' || $orderby == ''){
            $cr->status = 1;
            $cr->message = '输入信息不完整';
            return $cr->toJson();
        }

        $post = new Post();
        $post->name = $name;
        $post->orderby = $orderby;
        if($post->save()){
            $cr->status = 0;
            $cr->message = '添加成功';
            return $cr->toJson();
        }
        else{
            $cr->status = 1;
            $cr->message = '添加失败';
            return $cr->toJson();
        }
    }
}