<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入验证码类
use App\Tool\Validate\ValidateCode;
use App\Tool\SMS\SendTemplateSMS;
use App\Model\CodePhone;
use App\Models\M3Result;

class ValidateCodeController extends Controller
{
    //生成验证码
    public function create(Request $request)
    {
        $validateCode = new ValidateCode;
        $request->session()->put('validate_code',$validateCode->getCode());
        return $validateCode->doimg();
    }

    //发送短信
    public function sendSMS(SendTemplateSMS $sendtemplatesms,Request $request){
        $msresuit=new M3Result();
        $phone=$request->input('phone');
        if(CodePhone::where('phone',$phone)->first()){
            $msresuit->status = 1;
            $msresuit->message = '手机号已被注册！';
            return $msresuit->toJson();
        }
        if($phone==''){
            $msresuit->status=1;
            $msresuit->message='手机号不能为空！';
            return $msresuit->toJson();
        }
        $code='';
        $charset='12345678901';
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $sendtemplatesms->sendTemplateSMS('17875771967',array($code,60),1); //array(验证码，验证码持续时间)
        if ($msresuit->status==0){
            $codephone=new CodePhone();
            if($phone!='12345678901'){
                $msresuit->status=3;
                $msresuit->message='手机号错误！';
                return $msresuit->toJson();
            }
            $codephone->phone=$phone;
            $codephone->code='123456';
            $codephone->codetime=date('Y/m/d H:i:s',time());
            $res=$codephone->save();
            if($res==false){
                return '数据库插入错误！';
            }
        }
        //
        $msresuit->status=0;
        $msresuit->message='成功！';
        return $msresuit->toJson();
    }
}