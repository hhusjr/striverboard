<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
?>
<footer class="page-footer font-small red">
    <div class="footer-copyright text-center py-3">Hello World组</div>
</footer>
</div>
<div class="fixed-bottom bottom-widgets clearfix">
    <div class="bottom-widget">
        <span class="oi oi-arrow-thick-top" id="go-top"></span>
    </div>
</div>
<div class="modal fade animated" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true" data-url="">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title white-text w-100 font-weight-bold py-1"><i class="oi oi-arrow-circle-right"></i>
                    登陆</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <form class="needs-validation" id="login-form" novalidate>
                <div class="modal-body">
                    <div class="md-form mb-3">
                        <i class="oi oi-phone prefix grey-text"></i>
                        <input type="tel" id="login-phone" class="form-control"
                            pattern="^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$" required>
                        <label for="login-phone">手机号</label>
                        <div class="invalid-feedback">请填写合法的11位内地手机号码。</div>
                    </div>
                    <div class="md-form mb-3" id="login-password-group">
                        <i class="oi oi-key prefix grey-text"></i>
                        <input type="password" id="login-password" value="" class="form-control" pattern=".{5,}">
                        <label for="login-password">密码</label>
                        <div class="invalid-feedback">密码至少5位。</div>
                    </div>
                    <div id="login-verify-code-group" class="mb-3">
                        <div class="md-form input-group">
                            <button class="btn btn-md btn-block btn-red m-0 px-3" type="button"
                                id="login-get-verify-code">
                                <span id="login-get-verify-code-loading" class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true" style="display: none;"></span>
                                获取短信验证码
                            </button>
                        </div>
                        <div class="md-form">
                            <i class="oi oi-key prefix grey-text"></i>
                            <input type="number" min="111111" max="999999" class="form-control" value=""
                                id="login-verify-code">
                            <label for="login-verify-code">收到的验证码</label>
                            <div class="invalid-feedback">验证码不正确。</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around">
                        <div>
                            <a href="#" id="switch-to-verify-code-login">短信登陆</a>
                            <a href="#" id="switch-to-password-login">密码登陆</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-outline-danger waves-effect" id="do-login">登陆</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade animated right" id="msgbox-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info modal-lg modal-full-height modal-right" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title white-text w-100 font-weight-bold py-1"><i class="oi oi-document"></i>
                    信箱</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="spinner-border" id="load-message">
                    <div class="sr-only">Loading...</div>
                </div>
                <div id="messages-wrapper" data-page="1">
                    <p>暂未发现消息哦...</p>
                </div>
                <div class="d-flex justify-content-center" id="msgbox-pager">
                    <div class="msgbox-page-controller">
                        <button type="button" class="btn btn-sm btn-blue prev"><span
                                class="oi oi-caret-left"></span></button>
                        <button type="button" class="btn btn-sm btn-blue next"><span
                                class="oi oi-caret-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var loginParams = {
        verifyCodeDelayTime: <?php echo $a->verifyCodeDelay; ?> ,
        urls: {
            ajaxSendVerifyCode: '<?php ($a->U)('User', 'AjaxSendVerifyCode'); ?>',
            ajaxLogin: '<?php echo($a->U)('User', 'AjaxLogin'); ?>'
        }
    };

    var messageParams = {
        urls: {
            ajaxMessages: '<?php echo ($a->U)('Message', 'AjaxMessages'); ?>',
            ajaxSetMessageRead: '<?php echo ($a->U)('Message', 'AjaxSetMessageRead'); ?>',
            thumbsUpImg: '<?php echo ($a->S)('imgs/thumbs_up.jpg'); ?>',
            momentDetail: '<?php echo ($a->U)('Striverboard', 'MomentDetail'); ?>?mid='
        }
    };
</script>
<?php
    $loadJs = [
        'libs/mdb/js/bootstrap.min.js',
        'libs/mdb/js/popper.min.js',
        'libs/mdb/js/mdb.min.js',
        'libs/toastr/toastr.min.js',
        'libs/bootbox/bootbox.all.min.js',
        'js/formatter.js',
        'js/main.js'
    ];
    $loadJs = isset($a->js) ? array_merge($loadJs, $a->js) : $loadJs;
    foreach ($loadJs as $js) {
        ?>
<script src="<?php echo !is_array($js) ? ($a->S)($js, true) : $js[0]; ?>">
</script>
<?php
    }
?>
</body>

</html>