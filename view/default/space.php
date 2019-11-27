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
                    <h1 class="mb-3 red-text white-shadow"><i class="oi oi-person"></i> 奋斗者推荐</h1>
                </div>
                <div class="col-md-4">
                    <div class="container">
                        <form class="form-inline">
                            <div class="md-form my-0">
                                <input class="form-control" type="text" placeholder="奋斗者搜索" aria-label="奋斗者搜索">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                        $users = $a->recommendUsers;
                        foreach ($users as $user) {
                            ?>
                    <div class="col-md-3 py-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="oi oi-heart red-text" style="cursor: pointer;"></i>
                                    <?php echo $user->realName; ?>
                                </h4>
                                <ul class="list-unstyled list-inline font-small m-0">
                                    <li class="list-inline-item pr-2 grey-text"><i class="oi oi-home pr-1"></i>
                                        <?php echo $user->institution; ?>
                                    </li>
                                </ul>
                                <p class="card-text"><?php echo $user->mission; ?>
                                </p>
                                <ul class="list-unstyled list-inline font-small m-0">
                                    <li class="list-inline-item pr-2 grey-text"><i class="oi oi-audio pr-1"></i>
                                        <?php echo round($user->similarity * 100, 1); ?>%
                                    </li>
                                    <li class="list-inline-item pr-2 grey-text"><i class="oi oi-target pr-1"></i>
                                        <?php echo $user->field; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                        ?>
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
            ajaxNearestMoments: '<?php ($a->U)('Striverboard', 'AjaxGetNearestMoments'); ?>'
        }
    };
</script>
<?php
    $params = new stdClass;
    $params->js = [
        'js/formatter.js',
        'js/space.js'
    ];
    ($a->show)('include/footer', $params);
