@extends('layout.default')

@section('title')
    联系我们
@stop


@section('content')
    <div>
        <p>反馈信息</p>
        <form action="javascript:;" method="post">
            <div class="contact-form-left">
                <p>全名<em class="red">*</em></p>
                <input type="text" name="name"/>
                <p>邮箱<em class="red">*</em></p>
                <input type="text" name="email"/>
                <p>手机号<em class="red">*</em></p>
                <input type="text" name="mobile"/>
            </div>
            <div class="contact-form-right">
                <p>留言信息<em class="red">*</em></p>
                <textarea id="message" name="message" cols="55" rows="10"></textarea>

                <input type="submit" name="submit" value="提交"/>
                <div class="info" style="color: red;margin: 10px;font-size: 16px;display: none;">提交成功</div>
            </div>
        </form>

    </div>


@stop

@section('js')
    <script type="text/javascript">
        $('input[name="submit"]').click(function () {
            var name = $('input[name="name"]').val(),
                email = $('input[name="email"]').val(),
                mobile = $('input[name="mobile"]').val(),
                message = $('#message').val(),
                token = "{{ csrf_token() }}";
            if (name == '' || email == '' || mobile == '' || message == '') {
                alert('请填写反馈信息');
                return false;
            }
            var data = {
                'name': name,
                'email': email,
                'mobile': mobile,
                'message': message,
                '_token': token,
            };
            $.ajax({
                url: '/contact/feedback',
                data: data,
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    if (json.errcode == 0) {
                        $('.info').css('display', 'block');
                        setTimeout("location.reload()", 800);
                    } else {
                        alert(json.errmsg);
                        return false;
                    }
                }
            });
        });
    </script>
@stop
