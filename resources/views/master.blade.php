<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/book.css">
    <link rel="stylesheet" href="/css/weui.css">
</head>
<body>
<div class="bk_title_bar" style="position: relative;height: 50px; width: 100%;background-color:#2a2a2a;">
    <img src="/images/back.jpg" alt="" class="bk_back" style="position: absolute;width:30px;height: 30px;top: 10px; left: 10px;" onclick="history.go(-1)">
    <p class="bk_title_content" style="position: absolute;left: 50px;right: 50px;line-height: 50px;text-align: center; color: #dddddd">
        xxxx
    </p>
    <img onclick="onMenuClick();" src="/images/menu1.jpg" alt="" class="bk_menu" style="position: absolute;width:30px;height: 30px;top: 10px; right: 10px;" >
</div>
<div class="page">
    @yield('content')
</div>

<!-- tooltips -->
<div class="bk_toptips"><span></span></div>

{{--<div id="global_menu" onclick="onMenuClick();">
    <div></div>
</div>--}}

<!--BEGIN actionSheet-->
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">用户中心</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">选择套餐</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">周边油站</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">常见问题</div>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    function hideActionSheet(weuiActionsheet, mask) {
        weuiActionsheet.removeClass('weui_actionsheet_toggle');
        mask.removeClass('weui_fade_toggle');
        weuiActionsheet.on('transitionend', function () {
            mask.hide();
        }).on('webkitTransitionEnd', function () {
            mask.hide();
        })
    }
    // 设置标题
    $('.bk_title_content').html(document.title);


    function onMenuClick () {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle');
        mask.show().addClass('weui_fade_toggle').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_cancel').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
    }

    function onMenuItemClick(index) {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        hideActionSheet(weuiActionsheet, mask);
        if(index == 1) {

        } else if(index == 2) {

        } else if(index == 3){

        } else {
            $('.bk_toptips').show();
            $('.bk_toptips span').html("敬请期待!");
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        }
    }
</script>
@yield('my-js')
</html>