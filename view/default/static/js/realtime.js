var heatmapOverlay = null;
var userChart = null;

function loadMap() {
    $s.ajax({
        url: realtimeParams.urls.ajaxMomentsLocations,
        method: 'POST',
        dataType: 'json',
        success: function(points) {
            var max = 0;
            points.forEach(function(point) {
                if (point.count > max) max = point.count;
            });
            heatmapOverlay.setDataSet({
                data: points,
                max: max
            });
        }
    });
}

function loadUserGraph() {
    $s.post(realtimeParams.urls.ajaxUserGraph, function(data) {
        userChart.hideLoading();
        data.data.forEach(function(node) {
            node.symbolSize = 25;
            node.value = node.symbolSize;
            node.x = node.y = null;
            node.draggable = true;
            node.label = {
                show: true,
                formatter: function(item) {
                    return item.data.realName;
                }
            };
            node.itemStyle = {
                color: '#fff'
            };
        });
        option = {
            title: {
                text: '奋斗圈',
                top: 'bottom',
                left: 'right',
                textStyle: {
                    color: '#fff'
                }
            },
            tooltip: {
                formatter: function(item) {
                    if (item.dataType == 'node') {
                        return item.data.field + '领域的' + item.data.realName;
                    } else if (item.dataType == 'edge') {
                        return '使命相似度' + Math.round(item.value * 1000) / 10 + '%';
                    }
                }
            },
            animation: true,
            series: [{
                type: 'graph',
                layout: 'force',
                data: data.data,
                links: data.links,
                roam: true,
                lineStyle: {
                    normal: {
                        color: '#fff',
                        width: 3,
                        type: 'solid',
                        opacity: 0.5,
                        curveness: 0
                    }
                },
                label: {
                    normal: {
                        show: false,
                        position: 'right',
                        color: '#fff'
                    }
                },
                force: {
                    repulsion: 100
                }
            }]
        };

        userChart.setOption(option);
    }, 'json');
    $s(window).resize(function() {
        userChart.resize();
    });
}

$s(document).ready(function() {
    // load moments locations
    var map = new BMap.Map('heat-map-container');
    var point = new BMap.Point(118.464, 32.023);
    map.centerAndZoom(point, 5);
    map.enableScrollWheelZoom(true);
    heatmapOverlay = new BMapLib.HeatmapOverlay({
        radius: 80,
        visible: true
    });
    map.addOverlay(heatmapOverlay);
    map.setMapStyleV2({
        styleId: '1bdbedf1053dd50cc27fa71eb6c08be8'
    });
    loadMap();
    window.setInterval(loadMap, realtimeParams.refreshTime);

    // load user chart
    userChart = echarts.init(document.getElementById('user-graph'));
    userChart.showLoading();
    loadUserGraph();
    window.setInterval(loadUserGraph, realtimeParams.refreshTime);
});