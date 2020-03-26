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
    var realtimeServer = 'http://127.0.0.1';
    var realtimeParams = {
        urls: {
            ajaxMomentsLocations: realtimeServer + '/statistics/ajax_moments_locations',
            ajaxNewMoments: realtimeServer + '/striverboard/ajax_new_moments',
            ajaxUserGraph: realtimeServer + '/statistics/ajax_user_graph',
            ajaxHotMomentsWords: realtimeServer + '/striverboard/ajax_hot_moments_words',
            ajaxHotMissionWords: realtimeServer + '/user/ajax_hot_mission_words',
            ajaxMomentsCount: realtimeServer + '/striverboard/ajax_moments_count'
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
