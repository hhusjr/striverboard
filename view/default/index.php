<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = $a->slogan;
$params->css = ['css/index.css'];
($a->show)('include/header', $params);
?>
<div id="index-slide" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#index-slide" data-slide-to="0" class="active"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div class="view">
                <img class="d-none d-lg-block w-100"
                    src="<?php ($a->S)('imgs/index_slide/header1.jpg'); ?>"
                    alt="<?php echo $a->slogan; ?>">
                <img class="d-none d-lg-none d-md-block w-100"
                    src="<?php ($a->S)('imgs/index_slide/header1_md.jpg'); ?>"
                    alt="<?php echo $a->slogan; ?>">
                <img class="d-block d-md-none w-100"
                    src="<?php ($a->S)('imgs/index_slide/header1_sm.jpg'); ?>"
                    alt="<?php echo $a->slogan; ?>">
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#index-slide" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">上一张</span>
    </a>
    <a class="carousel-control-next" href="#index-slide" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">下一张</span>
    </a>
</div>
<div class="bg-white py-4 px-5 red-text">
    <h1 class="m-0"><i class="oi oi-arrow-circle-right"></i> 逛逛<a
            href="<?php echo($a->U)('Striverboard', 'Index'); ?>"
            class="red-text">奋斗墙</a></h1>
    <h3 class="m-0">或者，瞧瞧我们的“奋斗大数据” <i class="oi oi-arrow-circle-bottom"></i></h3>
</div>
<div id="strive-statistics">
    <div class="row m-0 p-0">
        <div class="col-lg-7 col-md-6 m-0 p-0">
            <div class="pr-3 pr-md-0">
                <div id="heat-map-container"></div>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 m-0 p-3">
            <div class="chart-container mb-2">
                <canvas id="words-chart" class="charts"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="age-chart" class="charts"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="blocks">
    <div class="block">
        <div class="container">
            <h1 class="mb-3">伟大的奋斗点滴</h1>
            <?php
                    $items = $a->greats;
                    $total = count($items);
                    $pagedDeckCount = ceil($total / 6);
                    $pageSize = 1;
                    printf('<div id="people" data-total="%d" data-size="%d" data-page="1"><div class="paged-decks">', $pagedDeckCount, $pageSize);
                    for ($i = 0; $i < $pagedDeckCount; $i++) {
                        $offset = $i * $pageSize * 6;
                        $endPoint = min($offset + $pageSize * 6, $total);
                        echo '<div class="row paged-deck" data-id="' . $i . '">';
                        for ($j = $offset; $j < $endPoint; $j++) {
                            ?>
            <div class="col-md-4 col-lg-2 col-sm-6 d-flex justify-content-center">
                <div class="ball">
                    <div class="ball-img">
                        <div class="view overlay zoom rounded-circle show-video" style="cursor: pointer;"
                            data-toggle="modal" data-target="#watch-video"
                            data-video-url="<?php echo $items[$j]->videoUrl; ?>"
                            data-title="<?php echo $items[$j]->name; ?>">
                            <img class="img-fluid z-depth-1 rounded-circle"
                                src="<?php echo $items[$j]->thumbnail; ?>"
                                alt="videos">
                            <div class="mask flex-center rgba-red-strong rounded-circle">
                                <p class="white-text">观看视频</p>
                            </div>
                        </div>
                    </div>
                    <p class="ball-text"><?php echo $items[$j]->name; ?><br><a
                            class="badge badge-danger"><?php echo $items[$j]->intro; ?></a></p>
                </div>
            </div>
            <?php
                        } ?>
        </div>
        <?php
                    }
                    ?>
    </div>
    <div class="d-flex justify-content-center pager">
        <div class="page-controller">
            <button type="button" class="btn btn-sm btn-red prev"><span class="oi oi-caret-left"></span></button>
            <button type="button" class="btn btn-sm btn-red next"><span class="oi oi-caret-right"></span></button>
        </div>
    </div>
</div>

</div>
</div>
</div>

<div class="modal fade" id="watch-video" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="heading lead" id="watch-video-title">视频标题</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <div class="modal-body mb-0 p-0" id="watch-video-body">
            </div>

            <div class="modal-footer mb-0 p-0">
                <a href="#" class="btn btn-lg btn-block btn-red" target="_blank" id="watch-video-bottom">无法播放？直接打开！</a>
            </div>
        </div>
    </div>
</div>

<script>
    var indexParams = {
        urls: {
            ajaxMomentsLocations: '<?php ($a->U)('Statistics', 'ajax_moments_locations'); ?>',
        },
        hotWordsLabels: JSON.parse(
            '<?php echo json_encode(array_keys($a->hotMissionWords)); ?>'
        ),
        hotWordsValues: JSON.parse(
            '<?php echo json_encode(array_values($a->hotMissionWords)); ?>'
        ),
        momentCountGroupByField: JSON.parse(
            '<?php echo json_encode($a->momentCountGroupByField); ?>')
    };
</script>
<?php
$params = new stdClass;
$params->js = [
    'js/index.js',
    ['https://api.map.baidu.com/api?v=3.0&ak=ckwII60VFiwURdLuKCuvBioZCeph7tL4'],
    ['https://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js']
];
($a->show)('include/footer', $params);
