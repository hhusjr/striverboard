// jquery alias
window.$s = jQuery.noConflict();

function loadMessages(page, onSuccess = function(success) {}) {
    if (page < 1) {
        onSuccess(false);
        return;
    }
    var found = false;
    $s('#load-message').fadeIn();
    $s.ajax({
        url: messageParams.urls.ajaxMessages,
        method: 'POST',
        dataType: 'json',
        data: {
            page: page
        },
        success: function(messages) {
            if (!messages.length) {
                onSuccess(false);
                return;
            }
            $s('#messages-wrapper').empty();
            messages.forEach(function(message) {
                var label = message.isRead ? '<span class="badge badge-pill badge-success is-read">已读</span> ' : '<span class="badge badge-pill badge-danger is-read">未读</span> ';
                var readConfirm = !message.isRead ? '<a role="button" data-msg-id="' + message.msgId + '" class="confirm-read"><i class="oi oi-check green-text animated rotateIn"></i></a>' : '';
                var toolbar = '<div class="d-flex"><div class="mr-auto"><p class="text-grey"><small><i class="oi oi-calendar"></i> ' + formatDay(message.time) + '</small></p></div><div>' + readConfirm + '</div></div>';
                var containerElement = $s('<div class="media d-block d-md-flex m-1"></div>');
                var imageElement = $s('<img class="d-flex mx-auto media-image z-depth-1 mb-3 mb-md-0" src="" style="width: 120px;" alt="">');
                var bodyElement = $s('<div class="media-body ml-md-3 ml-0">' + toolbar + '<p class="mt-0 font-weight-bold">' + label + '<span class="message-title"></span></p><p class="message-description"></p></div>');
                var titleElement = bodyElement.find('.message-title');
                var descriptionElement = bodyElement.find('.message-description');
                if (message.extra.moment) {
                    var imgs = message.extra.moment.imgs;
                    var img = imgs.length ? imgs[0] : messageParams.urls.thumbsUpImg;
                    var description = message.extra.moment.description;
                    var limit = 30;
                    if (description.length > limit) description = description.substr(0, limit) + '...';
                    var momentDetail = ' <a href="' + messageParams.urls.momentDetail + message.extra.moment.mid + '" target="_blank" class="view-detail"><i class="oi oi-eye"></i></a>';
                }
                switch (message.msgType) {
                    case 'newFollower':
                        imageElement.attr('src', messageParams.urls.thumbsUpImg);
                        imageElement.attr('alt', '新的关注者');
                        titleElement.html('新关注者');
                        descriptionElement.html('“' + message.extra.realName + '”开始关注你的奋斗点滴了哟～');
                        break;
                    case 'newLike':
                        imageElement.attr('src', img);
                        imageElement.attr('alt', '点赞提醒');
                        titleElement.html('点赞提醒' + momentDetail);
                        descriptionElement.html('<p>' + message.extra.realName + '给你点了个赞以表示对你奋斗的认可。请保持不忘初心，牢记使命，坚持奋斗！</p><blockquote><small>' + description + '</small></blockquote>');
                        break;
                    case 'newMoment':
                        imageElement.attr('src', img);
                        imageElement.attr('alt', '新的奋斗点滴');
                        titleElement.html('新奋斗点滴提醒');
                        descriptionElement.html('<p>你关注的' + message.extra.realName + '发布了新的奋斗点滴：</p><blockquote><small>' + description + '</small></blockquote>');
                        break;
                }
                containerElement.append(imageElement).append(bodyElement);
                $s('#messages-wrapper').append(containerElement).append('<hr>');
                containerElement.find('.confirm-read').click(function() {
                    var msgId = $s(this).attr('data-msg-id');
                    $s.ajax({
                        url: messageParams.urls.ajaxSetMessageRead,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            msg_id: msgId
                        },
                        success: function() {
                            $s('.unread-message-count').each(function() {
                                var me = $s(this);
                                me.text(parseInt(me.text()) - 1);
                            });
                            loadMessages(page);
                        },
                        error: function() {
                            toastr.error('由于未知错误无法将该消息标记为已读。');
                        }
                    });
                });
                found = true;
            });
            onSuccess(found);
        },
        complete: function() {
            $s('#load-message').fadeOut();
            $s('#msgbox-modal').animate({
                scrollTop: 0
            });
        },
        error: function() {
            toastr.error('由于未知错误无法加载消息列表。');
        }
    });
}

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

    // messagebox
    $s('#msgbox-modal').on('shown.bs.modal', function() {
        loadMessages(parseInt($s('#messages-wrapper').attr('data-page')));
    });
    $s('#msgbox-pager .prev').click(function() {
        var page = parseInt($s('#messages-wrapper').attr('data-page'));
        if (page <= 1) {
            $s('#msgbox-modal').animate({
                scrollTop: 0
            });
            toastr.error('不能再往前啦～');
            return;
        }
        loadMessages(page - 1, function(success) {
            if (success) {
                $s('#messages-wrapper').attr('data-page', page - 1);
            }
        });
    })
    $s('#msgbox-pager .next').click(function() {
        var page = parseInt($s('#messages-wrapper').attr('data-page'));
        loadMessages(page + 1, function(loaded) {
            if (loaded) {
                $s('#messages-wrapper').attr('data-page', page + 1);
            } else {
                console.log(page + 1);
                toastr.error('已经到最后一页了。');
            }
        });
    });
});