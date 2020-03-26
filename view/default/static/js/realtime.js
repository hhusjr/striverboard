var heatmapOverlay = null;
var userChart = null;
var hotMomentsWordsChart = null;
var hotMissionWordsChart = null;
var fieldChart = null;
var hookServerUrl = 'ws://127.0.0.1:9502';
var momentsCount = 0;
var loadedMids = [];

function card(attrs) {
    momentsCount++;
    var limit = 50;
    if (attrs.description.length > limit) attrs.description = attrs.description.substr(0, limit) + '...';

    var card = $s('<div class="card w-100 animated flipInX moment-important mb-4" data-mid="' + attrs.mid + '"></div>');
    if (attrs.significant) card.addClass('moment-important');

    var body = $s('<div class="card-body"></div>');
    body.append('<p class="card-text black-text"><span class="badge badge-pill badge-' + (attrs.achieved ? 'success">已完成' : 'danger">未完成') + '</span> ' + htmlspecialchars(attrs.description) + '</p>');
    body.append('<ul class="list-unstyled list-inline font-small m-0"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1"></i> ' + formatDay(attrs.time) + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-person pr-1"></i> ' + attrs.realName + '</li></ul>');
    card.append(body);

    var element = $s('<div class="col-lg-3 col-md-6 d-flex align-items-stretch"></div>');
    element.append(card);

    return element;
}

function loadNewMoments() {
    var newMomentsContainer = $s('#new-moments');
    $s.ajax({
        url: realtimeParams.urls.ajaxNewMoments,
        method: 'POST',
        dataType: 'json',
        success: function(moments) {
            if (!Array.isArray(moments)) {
                return;
            }
            moments.reverse();
            var mids = [];
            moments.forEach(function(attrs) {
                mids.push(attrs.mid);
            });
            newMomentsContainer.find('.card').each(function() {
                var me = $s(this);
                var mid = parseInt(me.attr('data-mid'));
                if (mids.indexOf(mid) == -1) {
                    me.hide();
                }
            });
            moments.forEach(function(attrs) {
                if (loadedMids.indexOf(attrs.mid) == -1) {
                    newMomentsContainer.prepend(card(attrs));
                    loadedMids.push(attrs.mid);
                }
            });
        }
    });
}

function loadHotMomentsWords() {
    $s.ajax({
        url: realtimeParams.urls.ajaxHotMomentsWords,
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            var words = [];
            var tfidf = [];
            var cnt = 12;
            var max = 0;
            Object.keys(response).forEach(function(word) {
                var value = parseFloat(response[word]);
                tfidf.push(value);
                if (value > max) {
                    max = value;
                }
            });
            Object.keys(response).forEach(function(word) {
                words.push({
                    name: word,
                    max: max
                });
            });
            words = words.slice(0, cnt);
            tfidf = tfidf.slice(0, cnt);

            hotMomentsWordsChart.hideLoading();

            var lineStyle = {
                normal: {
                    width: 5,
                    opacity: 0.5
                }
            };

            var option = {
                title: {
                    text: '奋斗热词',
                    right: 0,
                    bottom: 0,
                    textStyle: {
                        color: '#fff'
                    }
                },
                radar: {
                    radius: '60%',
                    indicator: words,
                    shape: 'circle',
                    splitNumber: 5,
                    name: {
                        textStyle: {
                            color: 'rgb(238, 197, 102)',
                            fontSize: 17
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: [
                                'rgba(238, 197, 102, 0.1)', 'rgba(238, 197, 102, 0.2)',
                                'rgba(238, 197, 102, 0.4)', 'rgba(238, 197, 102, 0.6)',
                                'rgba(238, 197, 102, 0.8)', 'rgba(238, 197, 102, 1)'
                            ].reverse()
                        }
                    },
                    splitArea: {
                        show: false
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'rgba(238, 197, 102, 0.5)',
                            width: 3
                        }
                    }
                },
                series: [{
                    name: '奋斗热词',
                    type: 'radar',
                    lineStyle: lineStyle,
                    data: [tfidf],
                    symbol: 'none',
                    itemStyle: {
                        normal: {
                            color: '#fff'
                        }
                    },
                    areaStyle: {
                        normal: {
                            opacity: 0.1
                        }
                    }
                }]
            };
            hotMomentsWordsChart.setOption(option);
            $s(window).resize(function() {
                hotMomentsWordsChart.resize();
            });
        }
    });
}

function loadHotMissionWords() {
    $s.ajax({
        url: realtimeParams.urls.ajaxHotMissionWords,
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            var words = [];
            var tfidf = [];
            var cnt = 12;
            var max = 0;
            Object.keys(response).forEach(function(word) {
                var value = parseFloat(response[word]);
                tfidf.push(value);
                if (value > max) {
                    max = value;
                }
            });
            Object.keys(response).forEach(function(word) {
                words.push({
                    name: word,
                    max: max
                });
            });
            words = words.slice(0, cnt);
            tfidf = tfidf.slice(0, cnt);

            hotMissionWordsChart.hideLoading();

            var lineStyle = {
                normal: {
                    width: 5,
                    opacity: 0.5
                }
            };

            var option = {
                title: {
                    text: '使命热词',
                    right: 0,
                    bottom: 0,
                    textStyle: {
                        color: '#fff'
                    }
                },
                radar: {
                    radius: '60%',
                    indicator: words,
                    shape: 'circle',
                    splitNumber: 5,
                    name: {
                        textStyle: {
                            color: 'rgb(238, 197, 102)',
                            fontSize: 17
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: [
                                'rgba(238, 197, 102, 0.1)', 'rgba(238, 197, 102, 0.2)',
                                'rgba(238, 197, 102, 0.4)', 'rgba(238, 197, 102, 0.6)',
                                'rgba(238, 197, 102, 0.8)', 'rgba(238, 197, 102, 1)'
                            ].reverse()
                        }
                    },
                    splitArea: {
                        show: false
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'rgba(238, 197, 102, 0.5)',
                            width: 3
                        }
                    }
                },
                series: [{
                    name: '使命热词',
                    type: 'radar',
                    lineStyle: lineStyle,
                    data: [tfidf],
                    symbol: 'none',
                    itemStyle: {
                        normal: {
                            color: '#fff'
                        }
                    },
                    areaStyle: {
                        normal: {
                            opacity: 0.1
                        }
                    }
                }]
            };
            hotMissionWordsChart.setOption(option);
            $s(window).resize(function() {
                hotMissionWordsChart.resize();
            });
        }
    });
}

function loadMap() {
    $s.ajax({
        url: realtimeParams.urls.ajaxMomentsLocations,
        method: 'POST',
        dataType: 'json',
        success: function(points) {
            if (!Array.isArray(points)) {
                return;
            }
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
        if (!data.data) {
            return;
        }
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
                color: '#ffcc66'
            };
        });
        var option = {
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
                        opacity: 0.7,
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

        $s(window).resize(function() {
            userChart.resize();
        });
    }, 'json');
}

function loadFieldChart() {
    $s.ajax({
        url: realtimeParams.urls.ajaxMomentsCount,
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            if (!Array.isArray(response)) {
                return;
            }
            var data = [];
            response.forEach(function(item) {
                var cnt = parseInt(item.cnt);
                if (!cnt) return true;
                data.push({
                    'name': item.name,
                    'value': cnt
                });
            });
            fieldChart.hideLoading();
            var option = {
                title: {
                    text: '领域奋斗',
                    bottom: 0,
                    right: 0,
                    textStyle: {
                        color: '#fff'
                    }
                },
                series: [{
                    name: '领域奋斗',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    data: data.sort(function(a, b) { return a.value - b.value; }),
                    roseType: 'radius',
                    label: {
                        normal: {
                            textStyle: {
                                color: 'rgba(255, 255, 255, 0.3)'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            lineStyle: {
                                color: 'rgba(255, 255, 255, 0.3)'
                            },
                            smooth: 0.2,
                            length: 10,
                            length2: 20
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#ffcc66',
                            shadowBlur: 30,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },
                    label: {
                        normal: {
                            fontSize: 17
                        }
                    },
                    animationType: 'scale',
                    animationEasing: 'elasticOut',
                    animationDelay: function(idx) {
                        return Math.random() * 200;
                    }
                }]
            };

            fieldChart.setOption(option);

            $s(window).resize(function() {
                fieldChart.resize();
            });
        }
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
    // load new moments
    loadNewMoments();
    // load hot moments words
    hotMomentsWordsChart = echarts.init(document.getElementById('hot-moments-words-radar'));
    hotMomentsWordsChart.showLoading();
    loadHotMomentsWords();
    // load hot mission words
    hotMissionWordsChart = echarts.init(document.getElementById('hot-mission-words-radar'));
    hotMissionWordsChart.showLoading();
    loadHotMissionWords();
    // load field chart
    fieldChart = echarts.init(document.getElementById('field-pie'));
    fieldChart.showLoading();
    loadFieldChart();
    // load user graph
    userChart = echarts.init(document.getElementById('user-graph'));
    userChart.showLoading();
    loadUserGraph();

    // web socket connection
    var ws = new WebSocket(hookServerUrl);
    ws.onmessage = function(event) {
        var action = JSON.parse(event.data);
        if (action.success) {
            switch (action.hook) {
                case 'newMoment':
                    loadMap();
                    loadNewMoments();
                    loadHotMomentsWords();
                    loadFieldChart();
                    break;
                case 'newUser':
                    loadUserGraph();
                    loadHotMissionWords();
                    break;
            }
        }
    }
});
