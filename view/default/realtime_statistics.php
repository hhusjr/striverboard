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
    <h1 class="m-0">奋斗墙实时数据</h1>
</div>
<div id="strive-statistics">
    <div class="row m-0 p-0">
        <div class="col-lg-7 col-md-6 m-0 p-0">
            <div id="heat-map-container"></div>
        </div>
        <div class="col-lg-5 col-md-6 m-0 p-0">
            <div id="user-graph-container">
                <div id="user-graph"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var realtimeParams = {
        urls: {
            ajaxMomentsLocations: '<?php ($a->U)('Statistics', 'ajax_moments_locations'); ?>',
            ajaxUserGraph: '<?php ($a->U)('Statistics', 'ajax_user_graph'); ?>'
        },
        refreshTime: 3000
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
