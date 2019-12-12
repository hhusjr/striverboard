<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '注册';
$params->css = ['css/main.css', 'css/register.css'];
($a->show)('include/header', $params);
?>
<div class="container-fluid">
    <div class="row d-flex justify-content-center my-4">
        <div class="col-lg-4 col-md-6">
            <div class="card p-4 mb-3">
                <form class="needs-validation" id="register-form" novalidate>
                    <p class="h4 mb-4 red-text">注册</p>
                    <div class="md-form mb-3">
                        <i class="oi oi-person prefix grey-text"></i>
                        <input type="text" id="register-realname" class="form-control" pattern=".{2,12}" required>
                        <label for="register-realname">姓名</label>
                        <div class="invalid-feedback">请填写合法的真实姓名。</div>
                    </div>
                    <div class="md-form mb-3">
                        <i class="oi oi-phone prefix grey-text"></i>
                        <input type="tel" id="register-phone" class="form-control"
                            pattern="^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$" required>
                        <label for="register-phone">手机号</label>
                        <div class="invalid-feedback">请填写合法的11位内地手机号码。</div>
                    </div>
                    <div id="register-verify-code-group" class="mb-3">
                        <div class="md-form input-group">
                            <button class="btn btn-md btn-block btn-red m-0 px-3" type="button" id="get-verify-code">
                                <span id="get-verify-code-loading" class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true" style="display: none;"></span>
                                获取短信验证码
                            </button>
                        </div>
                        <div class="md-form">
                            <i class="oi oi-key prefix grey-text"></i>
                            <input type="number" min="111111" max="999999" class="form-control"
                                id="register-verify-code" required>
                            <label for="register-verify-code">收到的验证码</label>
                            <div class="invalid-feedback">验证码不正确。</div>
                        </div>
                    </div>
                    <div class="md-form mb-3">
                        <i class="oi oi-key prefix grey-text"></i>
                        <input type="password" id="register-password" class="form-control" pattern=".{5,}" required>
                        <label for="register-password">密码</label>
                        <div class="invalid-feedback">密码至少五个字符。</div>
                    </div>
                    <div class="md-form mb-3">
                        <i class="oi oi-target prefix grey-text"></i>
                        <select id="register-field" class="mt-5 mb-0 browser-default custom-select md-form" required>
                            <?php
                                foreach ($a->fields as $field) {
                                    printf('<option value="%d">%s</option>', $field->fid, $field->name);
                                }
                            ?>
                        </select>
                        <label for="register-field">领域</label>
                    </div>
                    <div class="md-form mb-3">
                        <i class="oi oi-home prefix grey-text"></i>
                        <input type="text" id="register-institution" class="form-control" pattern=".{2,}" required>
                        <label for="register-institution">所在学校/机构/单位</label>
                        <div class="invalid-feedback">请输入2到22个字符。</div>
                    </div>
                    <div class="md-form mb-3">
                        <i class="oi oi-heart prefix grey-text"></i>
                        <textarea class="md-textarea form-control overflow-auto" rows="5" id="register-mission"
                            required></textarea>
                        <label for="register-mission">我的初心与使命</label>
                        <div class="invalid-feedback">请输入2到200个字符。</div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-danger waves-effect" id="do-register">
                            <span id="register-loading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true" style="display: none;"></span>
                            注册
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var registerParams = {
        verifyCodeDelayTime: '<?php echo $a->verifyCodeDelay; ?>',
        urls: {
            ajaxSendVerifyCode: '<?php ($a->U)('User', 'AjaxSendVerifyCode'); ?>',
            ajaxRegister: '<?php ($a->U)('User', 'AjaxRegister'); ?>',
            index: '<?php ($a->U)('Index', 'Index'); ?>'
        }
    };
</script>
<?php
$params = new stdClass;
$params->js = ['js/register.js'];
($a->show)('include/footer', $params);
