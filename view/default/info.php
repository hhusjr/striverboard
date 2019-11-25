<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new StdClass;
$params->subTitle = '消息提示';
$params->css = ['css/main.css'];
($assigns->show)('include/header', $params);
?>
<div class="container">
    <div
        class="alert alert-<?php echo $assigns->success ? 'success' : 'danger'; ?>">
        <?php echo $assigns->info; ?>&nbsp; &nbsp; <a
            href="<?php echo $assigns->redirect; ?>">回到上一页</a></div>
</div>
<?php ($assigns->show)('include/footer');
