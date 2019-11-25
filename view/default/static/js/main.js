// jquery alias
window.$s = jQuery.noConflict();

$s(document).ready(function() {
    // set the bootbox locale
    bootbox.setDefaults({
        locale: 'zh_CN'
    });

    // do the form validation
    $s('.needs-validation').submit(function(event) {
        var me = $s(this);
        if (me[0].checkValidity() === false) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
        me.addClass('was-validated');
    });

    // login check
    $s('#login-verify-code-group').hide();
    $s('#switch-to-password-login').hide();
    $s('#switch-to-verify-code-login').click(function() {
        $s('#login-password-group').slideUp();
        $s('#login-verify-code-group').slideDown();
        $s(this).hide();
        $s('#switch-to-password-login').show();
        $s('#login-password').val('');
    });
    $s('#switch-to-password-login').click(function() {
        $s('#login-password-group').slideDown();
        $s('#login-verify-code-group').slideUp();
        $s(this).hide();
        $s('#switch-to-verify-code-login').show();
        $s('#login-verify-code').val('');
    });
    // get the message verify code
    $s('#login-get-verify-code').click(function() {
        var me = $s(this);
        me.attr('disabled', 'disabled');
        $s('#login-get-verify-code-loading').fadeIn();
        // send the message
        $s.ajax({
            url: loginParams.urls.ajaxSendVerifyCode,
            method: 'POST',
            dataType: 'json',
            data: {
                'phone': $s('#login-phone').val(),
                'type': 'login'
            },
            success: function(response) {
                if (response.success) {
                    // to avoid someone sending message too frequently
                    // TODO: More strict, add Api token verification, picture verify code...
                    var time = loginParams.verifyCodeDelayTime;
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
                    toastr.error('发送失败，请检查手机号是否已被注册过，或发送过于频繁。');
                    me.removeAttr('disabled');
                }
            },
            error: function() {
                toastr.error('系统出现错误。');
                me.removeAttr('disabled');
            },
            complete: function() {
                $s('#login-get-verify-code-loading').fadeOut();
            }
        });
    });
    $s('#login-form').submit(function() {
        $s.ajax({
            url: loginParams.urls.ajaxLogin,
            method: 'POST',
            data: {
                phone: $s('#login-phone').val(),
                password: $s('#login-password').val(),
                verify_code: $s('#login-verify-code').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success('恭喜你，登陆成功！即将自动刷新网页...');
                    $s('#login-modal').modal('hide');
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error('请检查手机号和密码/验证码是否填写正确。');
                    $s('#login-modal').addClass('headShake');
                    window.setTimeout(function() {
                        $s('#login-modal').removeClass('headShake');
                    }, 1000);
                }
            }
        });
        event.preventDefault();
    });

    // scroll to the top
    $s('#go-top').click(function() {
        $s('html, body').animate({
            scrollTop: 0
        });
    });
});