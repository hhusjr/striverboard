<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
?>
<!DOCTYPE HTML>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title"
        content="<?php echo $assigns->sitename; ?>">
    <?php
        $loadCss = [
            'libs/mdb/css/bootstrap.min.css',
            'libs/mdb/css/mdb.min.css',
            'libs/toastr/toastr.min.css',
            'libs/openiconic/css/open-iconic-bootstrap.css',
            'css/common.css'
        ];
        $loadCss = isset($a->css) ? array_merge($loadCss, $a->css) : $loadCss;
        foreach ($loadCss as $css) {
            ?>
    <link
        href="<?php echo !is_array($css) ? ($a->S)($css, true) : $css[0]; ?>"
        rel="stylesheet">
    <?php
        }
    ?>
    <script
        src="<?php ($a->S)('libs/mdb/js/jquery-3.4.1.min.js'); ?>">
    </script>
    <script>
        jQuery(document).ready(function() {
            if (('standalone' in window.navigator) && window.navigator.standalone) {
                jQuery('a').on('click', function(e) {
                    e.preventDefault();
                    var newLocation = jQuery(this).attr('href');
                    if (newLocation != undefined &&
                        newLocation.substr(0, 1) != '#' &&
                        jQuery(this).attr('data-method') == undefined) {
                        window.location.href = newLocation;
                    }
                });
            }
        });
    </script>
    <title><?php echo $a->subTitle; ?> - <?php echo $a->sitename; ?>
    </title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark light-darken fixed-top scrolling-navbar">
            <div class="container">
                <a class="navbar-brand logo" href="#"><img
                        src="<?php ($a->S)('imgs/logo.png'); ?>"
                        alt="<?php echo $a->sitename; ?>"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-navbar"
                    aria-controls="header-navbar" aria-expanded="false" aria-label="展开/折叠菜单">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo($a->U)('Index', 'Index'); ?>">主页</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo($a->U)('Striverboard', 'Index'); ?>">奋斗墙</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo($a->U)('Striverboard', 'Space'); ?>">奋斗圈</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo($a->U)('Greats', 'Index'); ?>">伟人的奋斗</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto nav-flex-icons">
                        <li class="nav-item">
                            <form class="form-inline">
                                <div class="md-form my-0">
                                    <input class="form-control mr-sm-2" type="text" placeholder="聚合搜索"
                                        aria-label="聚合搜索">
                                </div>
                            </form>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light">
                                <i class="oi oi-vertical-align-bottom"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="user-action" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="oi oi-person"></i>
                                <?php echo ($a->user) ? $a->user->realName : ''; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default">
                                <?php
                                if (!$a->user) {
                                    ?>
                                <a class="dropdown-item" data-toggle="modal" data-target="#login-modal"
                                    href="<?php ($a->U)('User', 'Login'); ?>"><i
                                        class="oi oi-arrow-circle-right"></i> 登陆</a>
                                <a class="dropdown-item"
                                    href="<?php ($a->U)('User', 'Register'); ?>"><i
                                        class="oi oi-check"></i> 注册</a>
                                <?php
                                } else {
                                    ?>
                                <a class="dropdown-item"
                                    href="<?php ($a->U)('User', 'Logout'); ?>">
                                    <i class="oi oi-ban"></i> 注销登陆</a>
                                <a class="dropdown-item"
                                    href="<?php ($a->U)('User', 'Modify'); ?>">
                                    <i class="oi oi-pencil"></i> 编辑资料</a>
                                <?php
                                }
                                ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>