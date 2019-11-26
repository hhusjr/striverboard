$s.fn.extend({
    //paged deck extension
    'pagedDecks': function() {
        var element = $s(this);
        var deckCount = parseInt(element.attr('data-total'));
        var sizePerPage = parseInt(element.attr('data-size'));
        if (!element.attr('data-page')) element.attr('data-page', 1);
        var deckCurrentPage = element.attr('data-page');
        var pagedDecks = element.children('.paged-decks');
        var decks = pagedDecks.children('.paged-deck');
        var pager = element.children('.pager').children('.page-controller');
        var pagerPrev = pager.children('.prev');
        var pagerNext = pager.children('.next');
        var totalPage = Math.ceil(deckCount / sizePerPage);
        var scroll = function() {
            $s('html, body').animate({
                scrollTop: $s(element).offset().top - 72
            }, 500);
        }
        var load = function(init) {
            decks.hide();
            var from = (deckCurrentPage - 1) * sizePerPage;
            var to = from + sizePerPage - 1;
            // control the displayed decks
            decks.each(function() {
                var me = $s(this);
                var id = parseInt(me.attr('data-id'));
                if (id >= from && id <= to) {
                    me.fadeIn();
                }
            });
            // control the pager
            if (deckCurrentPage >= totalPage) {
                pagerNext.attr('disabled', 'disabled');
            } else {
                pagerNext.removeAttr('disabled');
            }
            if (deckCurrentPage <= 1) {
                pagerPrev.attr('disabled', 'disabled');
            } else {
                pagerPrev.removeAttr('disabled');
            }
            if (!init) scroll();
        };
        pagerPrev.click(function() {
            deckCurrentPage--;
            load(false);
        });
        pagerNext.click(function() {
            deckCurrentPage++;
            load(false);
        });
        load(true);
    }
});

function loadMap() {
    var map = new BMap.Map('heat-map-container');
    var point = new BMap.Point(118.464, 32.023);
    map.centerAndZoom(point, 5);
    map.enableScrollWheelZoom(true);
    $s.ajax({
        url: indexParams.urls.ajaxMomentsLocations,
        method: 'POST',
        dataType: 'json',
        success: function(points) {
            var max = 0;
            points.forEach(function(count) {
                if (count > max) max = count;
            });
            var heatmapOverlay = new BMapLib.HeatmapOverlay({
                radius: 80,
                visible: true
            });
            map.addOverlay(heatmapOverlay);
            heatmapOverlay.setDataSet({
                data: points,
                max: max
            });
        }
    });
    map.setMapStyleV2({
        styleId: '1bdbedf1053dd50cc27fa71eb6c08be8'
    });
}

function loadChart() {
    var ctxR = document.getElementById('words-chart').getContext('2d');
    var myRadarChart = new Chart(ctxR, {
        type: 'radar',
        data: {
            labels: indexParams.hotWordsLabels,
            datasets: [{
                label: '奋斗热词排行',
                data: indexParams.hotWordsValues,
                backgroundColor: [
                    'rgba(105, 0, 132, .2)',
                ],
                borderColor: [
                    'rgba(200, 99, 132, .7)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true
        }
    });
    //pie
    var ctxP = document.getElementById('age-chart').getContext('2d');
    var topFields = indexParams.momentCountGroupByField.slice(0, 5);
    var topFieldLabels = [],
        topFieldData = [];
    topFields.forEach(function(field) {
        topFieldLabels.push(field.name);
        topFieldData.push(field.cnt);
    });
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: topFieldLabels,
            datasets: [{
                data: topFieldData,
                backgroundColor: ['#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360'],
                hoverBackgroundColor: ['#FF5A5E', '#5AD3D1', '#FFC870', '#A8B3C5', '#616774']
            }]
        },
        options: {
            responsive: true
        }
    });

}

$s(document).ready(function() {
    $s('#people').pagedDecks();
    loadMap();
    $s('#strive-statistics, .charts').css('height', 'auto');
    loadChart();

    // when users want to watch the video
    $s('.show-video').click(function() {
        var me = $s(this);
        $s('#watch-video-title').text(me.attr('data-title'));
        $s('#watch-video-body').empty();
        $s('#watch-video-body').html('<div class="embed-responsive embed-responsive-16by9 z-depth-1-half"><iframe class="embed-responsive-item" src="' + me.attr('data-video-url') + '" allowfullscreen></iframe></div>');
        $s('#watch-video-bottom').attr('href', me.attr('data-video-url'));
    });

    $s('#watch-video').on('hidden.bs.modal', function() {
        $s('#watch-video-body').empty();
    });
});