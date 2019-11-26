<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '奋斗圈';
$params->css = ['css/striverboard.css'];
($a->show)('include/header', $params);
?>
<div class="container-fluid">

</div>
<?php
$params = new stdClass;
$params->js[] = 'js/space.js';
($a->show)('include/footer', $params);
