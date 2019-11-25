$s(document).ready(function() {
    // get the message verify code
    $s('#get-verify-code').click(function() {
        var me = $s(this);
        me.attr('disabled', 'disabled');
        $s('#get-verify-code-loading').fadeIn();
        // send the message
        $s.ajax({
            url: registerParams.urls.ajaxSendVerifyCode,
            method: 'POST',
            dataType: 'json',
            data: {
                'phone': $s('#register-phone').val(),
                'type': 'register'
            },
            success: function(response) {
                if (response.success) {
                    // to avoid someone sending message too frequently
                    // TODO: More strict, add Api token verification, picture verify code...
                    var time = registerParams.verifyCodeDelayTime;
                    var counter = window.setInterval(function() {
                        if (!time) {
                            window.clearInterval(counter);
                            me.removeAttr('disabled');
                            me.text('获取短信验证码');
                            return;
                        }
                        me.text('再过' + time + '秒后可再次发送...');
                        time--;
                    }, 1000);
                    toastr.success('短信发送成功啦！请查收验证码哦～');
                } else {
                    toastr.error('发送失败，请检查手机号是否输入正确，或发送过于频繁。');
                    me.removeAttr('disabled');
                }
            },
            error: function() {
                toastr.error('系统出现错误。');
                me.removeAttr('disabled');
            },
            complete: function() {
                $s('#get-verify-code-loading').fadeOut();
            }
        });
    });

    // do ajax register
    $s('#register-form').submit(function() {
        $s('#do-register').attr('disabled', 'disabled');
        $s('#register-loading').fadeIn();
        var data = {
            real_name: $s('#register-realname').val(),
            password: $s('#register-password').val(),
            phone: $s('#register-phone').val(),
            mission: $s('#register-mission').val(),
            fid: $s('#register-field').val(),
            institution: $s('#register-institution').val(),
            verify_code: $s('#register-verify-code').val()
        };
        $s.ajax({
            url: registerParams.urls.ajaxRegister,
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                if (response.success) {
                    toastr.success('注册成功啦！请登陆哟～');
                    $s('#login-modal').modal('show');
                } else {
                    switch (response.error) {
                        case 'phone':
                            toastr.error('手机号码存在问题。请检查该手机号码格式以及是否被注册过。');
                            break;
                        case 'msgVerifyCode':
                            toastr.error('手机验证码填写错误。');
                            break;
                        case 'mission':
                            toastr.error('初心与使命应在2～200字符内。');
                            break;
                        case 'institution':
                            toastr.error('机构名称应该仅由中文、英文字母、数字、下划线、中划线构成。');
                            break;
                        default:
                            toastr.error('注册失败，请检查你填写的信息是否合法。');
                    }
                }
            },
            error: function(response) {
                toastr.error('注册失败。');
            },
            complete: function() {
                $s('#do-register').removeAttr('disabled');
                $s('#register-loading').fadeOut();
            }
        });
        event.preventDefault();
    });
});