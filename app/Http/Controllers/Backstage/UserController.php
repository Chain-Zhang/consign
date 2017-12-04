<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/22
 * Time: 下午8:18
 */

namespace App\Http\Controllers\Backstage;


use App\Http\Controllers\Controller;
use App\Models\ConsignResult;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class UserController extends Controller
{
    use RegistersUsers;

    public function index(){
        $users = User::where([])->orderby('created_at')->get();
        foreach($users as $user){
            $post = Post::find($user->post_id);
            if($post != null){
                $user->role = $post->name;
            }
        }
        return response()->json($users);
    }

    public function getEmplyee(){
        $allusers = User::where([])->orderby('name')->get();
        $users = array();
        foreach($allusers as $user){
            $post = Post::find($user->post_id);
            if($post != null && $post->orderby > 0){
                array_push($users, $user);
            }
        }
        return response()->json($users);
    }

    public function add(Request $request){
        $cr = new ConsignResult();
        $name = $request->input('name','');
        $phone = $request->input('phone', '');
        $post_id = $request->input('post_id','');

        if($name == '' || $phone == ''){
            $cr->status = 1;
            $cr->message = '姓名和电话不能为空';
            return $cr->toJson();
        }
        if($post_id == ''){
            $post_id = 99;
        }
        $user = new User();
        $user->name = $name;
        $user->phone = $phone;
        $user->post_id = $post_id;
        $user->isActive = true;
        $user->password = bcrypt('123456');

        if($user->save()){
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