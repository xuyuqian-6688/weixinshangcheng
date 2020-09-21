<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
//引入验证码类
use App\Tool\Validate\ValidateCode;
use App\Tool\SMS\SendTemplateSMS;
use App\Model\CodePhone;
use App\Models\M3Result;

use App\Model\Member;


class LoginController extends Controller
{
    //显示登录页面
    public function login()
    {
        return view('login');
    }
    //显示注册
    public function register()
    {
        return view('register');
    }
    //响应注册下的手机是否已存在（Ajax）
    /*public function phoneAjax(Request $request)
    {
       // dd($request->all());
    }*/

    //注册
    public function toregister1(Request $request,Member $member)
    {

    }

    public function toregister(Request $request)
    {
        $email = $request->input('email', '');
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        $confirm = $request->input('confirm', '');
        $phone_code = $request->input('phone_code', '');
        $validate_code = $request->input('validate_code', '');

        $m3_result = new M3Result;
        if(CodePhone::where('phone',$phone)->first()){
            $m3_result->status = 1;
            $m3_result->message = '手机号已被注册！';
            return $m3_result->toJson();
        }

        if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }

        // 手机号注册
        if($phone != '') {
            if($phone_code == '' || strlen($phone_code) != 6) {
                $m3_result->status = 5;
                $m3_result->message = '手机验证码为6位';
                return $m3_result->toJson();
            }

            $tempPhone = CodePhone::where('phone', $phone)->first();
            if($tempPhone){
                if($tempPhone->code == $phone_code) {
                    $member = new Member;
                    $member->phone = $phone;
                    $member->password = md5($password);
                    $member->save();

                    $m3_result->status = 0;
                    $m3_result->message = '注册成功';
                    return $m3_result->toJson();

                } else {
                    $m3_result->status = 7;
                    $m3_result->message = '手机验证码不正确';
                    return $m3_result->toJson();
                }
            }else{
                $m3_result->status = 1;
                $m3_result->message = '服务器错误';
                return $m3_result->toJson();
            }


            // 邮箱注册
        } else {
            $member = new Member;
            if($member::where('email',$email)->first()){
                $m3_result->status = 1;
                $m3_result->message = '改邮箱已被注册！';
                return $m3_result->toJson();
            }
            $member->email = $email;
            $member->password = md5($password);
            $member->save();

            /*$uuid = UUID::create();

            $m3_email = new M3Email;
            $m3_email->to = $email;
            $m3_email->cc = 'magina@speakez.cn';
            $m3_email->subject = '凯恩书店验证';
            $m3_email->content = '请于24小时点击该链接完成验证. http://book.magina.com/service/validate_email'
                . '?member_id=' . $member->id
                . '&code=' . $uuid;

            $tempEmail = new TempEmail;
            $tempEmail->member_id = $member->id;
            $tempEmail->code = $uuid;
            $tempEmail->deadline = date('Y-m-d H-i-s', time() + 24*60*60);
            $tempEmail->save();

            Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                // $m->from('hello@app.com', 'Your Application');
                $m->to($m3_email->to, '尊敬的用户')
                    ->cc($m3_email->cc)
                    ->subject($m3_email->subject);
            });*/

            $m3_result->status = 0;
            $m3_result->message = '注册成功';
            return $m3_result->toJson();
        }
    }

    //登录验证
    public function tologin(Request $request,Member $member)
    {
        $m3_result = new M3Result;
        $username=$request->get('phone');
        $password=$request->get('password');
        $validate_code=$request->get('validate_code');


        //获取session
        $validate=$request->session()->get('validate_code');
        if($validate==$validate_code){
            $m3_result->status=1;
            $m3_result->message='验证码错误';
            return $m3_result->toJson();
           // return response()->json('验证码错误');
        }

        //
        $res=$member->where('phone',$username)->first();
        //$res1=$member->where('email',$username)->first();
        if($res===false){
            $m3_result->status=2;
            $m3_result->message='用户不存在';
            return $m3_result->toJson();
        }
        if(md5($password)!=$res->password){
            $m3_result->status=2;
            $m3_result->message='密码不正确';
            return $m3_result->toJson();
        }
        $request->session()->put('tologin',true);
        $m3_result->status=0;
        $m3_result->message='登录成功';
        return $m3_result->toJson();
    }

}