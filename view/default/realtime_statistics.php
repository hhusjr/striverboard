<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '实时数据';
$params->css = ['css/main.css', 'css/realtime.css'];
($a->show)('include/header', $params);
?>
<div class="bg-white py-4 px-5 red-text">
    <h1 class="m-0">奋斗墙 <small>实时</small></h1>
</div>
<div class="container-fluid" id="new-data-container">
    <div class="row" id="new-moments"></div>
</div>
<div id="realtime-statistics">
    <div class="row m-0 p-0">
        <div class="col-lg-6 col-md-7 m-0 p-0">
            <div id="heat-map-container"></div>
        </div>
        <div class="col-lg-6 col-md-5 m-0 p-0">
            <div id="user-graph-container">
                <div id="user-graph"></div>
            </div>
        </div>
    </div>
</div>
<div class="connector"></div>
<div class="container-fluid" id="detail-statistics-container">
    <div class="row pb-2" id="detail-statistics">
        <div class="col-md-6">
            <p class="detail-title">数据统计<br><i class="oi oi-bar-chart"></i></p>
        </div>
        <div class="col-md-6">
            <div id="hot-moments-words-radar" class="detail-charts"></div>
        </div>
        <div class="col-md-6">
            <div id="hot-mission-words-radar" class="detail-charts"></div>
        </div>
        <div class="col-md-6">
            <div id="field-pie" class="detail-charts"></div>
        </div>
    </div>
</div>
<script>
    var realtimeParams = {
        urls: {
            ajaxMomentsLocations: '<?php ($a->U)('Statistics', 'AjaxMomentsLocations'); ?>',
            ajaxNewMoments: '<?php ($a->U)('Striverboard', 'AjaxNewMoments'); ?>',
            ajaxUserGraph: '<?php ($a->U)('Statistics', 'AjaxUserGraph'); ?>',
            ajaxHotMomentsWords: '<?php ($a->U)('Striverboard', 'AjaxHotMomentsWords'); ?>',
            ajaxHotMissionWords: '<?php ($a->U)('User', 'AjaxHotMissionWords'); ?>',
            ajaxMomentsCount: '<?php ($a->U)('Striverboard', 'AjaxMomentsCount'); ?>'
        }
    };
</script>
<?php
$params = new stdClass;
$params->js = [
    'js/realtime.js',
    ['https://api.map.baidu.com/api?v=3.0&ak=ckwII60VFiwURdLuKCuvBioZCeph7tL4'],
    ['https://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js'],
    'libs/echarts/echarts.min.js'
];
($a->show)('include/footer', $params);
