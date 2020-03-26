<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '奋斗圈';
$params->css = ['css/main.css', 'css/space.css'];
($a->show)('include/header', $params);
?>
<div class="blocks">
    <div class="block space space-1">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="mb-3 red-text white-shadow"><i class="oi oi-person"></i> 斗友们</h1>
                </div>
                <div class="col-md-4">
                    <div class="container">
                        <form class="form-inline">
                            <div class="md-form my-0">
                                <input class="form-control" id="search-users" type="text" placeholder="奋斗者搜索" aria-label="奋斗者搜索">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="spinner-border red-text" role="status" id="loading-users">
                    <span class="sr-only">加载...</span>
                </div>
                <div class="grid" id="users-container">
                </div>
            </div>
        </div>
    </div>

    <div class="block space space-2">
        <div class="container">
            <h1 class="mb-3"><i class="oi oi-location"></i> 附近点滴</h1>
            <div>
                <div class="spinner-grow red-text" role="status" id="loading-moments">
                    <span class="sr-only">加载...</span>
                </div>
            </div>
            <div class="row" id="moments">
            </div>
        </div>
    </div>
</div>

<script>
    var spaceParams = {
        urls: {
            thumbsUpImgUrl: '<?php ($a->S)('imgs/thumbs_up.jpg'); ?>',
            ajaxNearestMoments: '<?php ($a->U)('Striverboard', 'AjaxGetNearestMoments'); ?>',
            momentDetail: '<?php echo($a->U)('Striverboard', 'MomentDetail'); ?>?mid=',
            userStriverboard: '<?php echo($a->U)('Striverboard', 'Index'); ?>?uid=',
            ajaxSearchUsers: '<?php echo($a->U)('Striverboard', 'SearchUsers'); ?>'
        }
    };
</script>
<?php
    $params = new stdClass;
    $params->js = [
        'libs/mdb/js/addons/masonry.pkgd.min.js',
        'js/space.js'
    ];
    ($a->show)('include/footer', $params);
