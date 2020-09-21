@extends("master")


@section('title')
    登录
@endsection
@section('content')
    <div class="weui_cells_title"></div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="tel" placeholder="邮箱或手机号" name="phone" id="phone"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="tel" placeholder="不少于6位" id="password" name="password"/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="请输入验证码"  id="validate"/>
            </div>
            <div class="weui_cell_ft" style="margin-right: 15px;">
                <img src="/validate" class="bk_validate_code" id="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href='' id="login">登录</a>
    </div>
    <div class="bk_toptips" style="display: none;"><span>请输入手机号</span></div>
    @if(session("error"))
        <div class="bk_toptips" style="display: block;"><span>{{session('error')}}</span></div>
    @endif
    <a href="/register" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection

@section('my-js')
    <script type="text/javascript">
        $(function () {
            $('.bk_validate_code').click(function () {
                $('#bk_validate_code').attr('src', '/validate?random='+ Math.random());
                //alert(1);
            });
        });

        $(function () {
            $('#login').click(function () {
                var phone = $('#phone').val();
                var password = $('#password').val();
                var validate=$('#validate').val();
                if(phone =='') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入手机号或邮箱');
                    setTimeout(function() {$('.bk_toptips').hide();},5000);
                }
                // 手机号格式
                if(phone.length != 11 || phone[0] != '1') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('手机格式不正确');
                    setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                    return;
                }
                if(password===''){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('密码不能为空');
                    setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                }
                if(validate===''){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入验证码');
                    setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                }
                $.ajax({
                    type: "POST",
                    url: '/tologin',
                    dataType: 'json',
                    cache: false,
                    data: {phone: phone, password: password, _token: "{{csrf_token()}}",validate_code:validate},
                    success: function(data) {
                        if(data == null) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html('服务端错误');
                            setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                            return;
                        }
                        if(data.status != 0) {
                            alert(2222);
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html(data.message);
                            setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                            return;
                        }
                        //alert(1111111);
                        location.href="/a";
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('登录成功');
                        setTimeout(function() {$('.bk_toptips').hide();}, 5000);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);

                    }
                });
            });
        });


    </script>
@endsection