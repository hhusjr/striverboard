var page = 1;
var finished = false;
var momentsCount = 0;
var timelineView = striverboardParams.timelineView;

function formatDay(time) {
    var time = new Date(time * 1000);
    return (time.getMonth() + 1) + '月' + time.getDate() + '日' + time.getHours() + '时' + time.getMinutes() + '分';
}

function card(attrs) {
    momentsCount++;
    if (attrs.description.length > limit) attrs.description = attrs.description.substr(0, limit) + '...';

    var slide = $s('<div class="carousel slide moment-slides" data-interval="0" data-ride="carousel" id="moment' + momentsCount + '-slider"></div>');
    var inner = $s('<div class="carousel-inner"></div>');
    var imgs = attrs.imgs;
    imgs.forEach(function(img) {
        inner.append('<div class="carousel-item"><img class="d-block w-100" src="' + img + '" alt="' + attrs.description + '"></div>');
    });
    inner.children(':first').addClass('active');
    slide.append(inner);
    slide.append('<a class="carousel-control-prev" href="#moment' + momentsCount + '-slider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">上一张</span></a><a class="carousel-control-next" href="#moment' + momentsCount + '-slider" role="button"data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">下一张</span></a>');

    var card = $s('<div class="card"></div>');
    if (attrs.significant) card.addClass('moment-important');

    if (imgs.length) card.append(slide);

    var limit = 50;
    var body = $s('<div class="card-body"></div>');
    body.append('<p class="card-text black-text"><span class="badge badge-pill badge-' + (attrs.achieved ? 'success">已完成' : 'danger">未完成') + '</span> ' + attrs.description + '</p>');
    body.append('<ul class="list-unstyled list-inline font-small m-0"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1"></i> ' + formatDay(attrs.time) + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-person pr-1"></i> ' + attrs.realName + '</li></ul>');
    card.append(body);

    if (timelineView) {
        var element = $s('<div class="timeline-post red-post"></div>');
        var time = new Date(attrs.time * 1000);
        element.append('<div class="timeline-icon icon-larger iconbg-red icon-color-white"><div class="icon-placeholder">' + (1 + time.getMonth()) + ' <span>' + time.getDate() + '</span></div><div class="timeline-bar"></div></div>');
        var details = $s('<div class="timeline-content p-1" data--10-bottom-top="transform: rotateX(-90deg); opacity: 0;" data--80-bottom-bottom="transform: rotateX(0deg); opacity: 1;"><div class="content-details"></div></div>');
        details.append(card);
        element.append(details);
        return element;
    }

    var element = $s('<div class="grid-item col-lg-4 col-md-6"></div>');
    element.append(card);

    return element;
}

function loadMoments(onSuccess) {
    if (finished) return;
    if (!timelineView) $s('#loading-moments').fadeIn();
    var data = {
        page: page,
        uid: striverboardParams.showUid,
        significant: striverboardParams.significant,
        achieved: striverboardParams.achieved,
        fid: striverboardParams.field
    };
    $s.ajax({
        url: striverboardParams.urls.ajaxMoments,
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(moments) {
            if (!moments.length) {
                finished = true;
                toastr.success('奋斗点滴全部加载完了哦～');
                if (!timelineView) $s('#loading-moments').fadeOut();
                onSuccess();
                return;
            }
            moments.forEach(function(moment) {
                if (!timelineView) $s('#loading-moments').before(card(moment));
                else $s('#timeline-view').append(card(moment));
            });
            if (!timelineView) $s('#loading-moments').fadeOut(function() {
                onSuccess();
            });
            else onSuccess();
        }
    });
    page++;
}

var sk;

$s(document).ready(function() {
    // hide a view
    if (timelineView) {
        $s('#grid-view').hide();
        sk = skrollr.init({ forceHeight: false });
    } else {
        $s('#timeline-view').hide();
        // when slide, relayout
        $s(document).on('slid.bs.carousel', '.moment-slides', function() {
            $grid.masonry('reloadItems');
            $grid.masonry('layout');
        });
    }

    // init Masonry
    var $grid = $s('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });

    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function() {
        $grid.masonry();
    });

    // load moments and scrolling to show more
    loadMoments(function() {
        if (timelineView) {
            sk.refresh();
            return;
        }
        $grid.masonry('reloadItems');
        $grid.masonry('layout');
    });
    $s(window).scroll(function() {
        if (finished) return;
        if ($s(document).height() - $s(this).height() - $s(this).scrollTop() < 1) {
            loadMoments(function() {
                if (timelineView) {
                    sk.refresh();
                    return;
                }
                $grid.masonry('reloadItems');
                $grid.masonry('layout');
            });
        }
    });

    // load user mission words
    if (striverboardParams.missionWords) {
        var entries = [];
        striverboardParams.missionWords.forEach(function(mission) {
            entries.push({
                label: mission,
                url: '#',
                target: '_top'
            });
        });
        // repeat, to see more words in the words cloud, enhancing the effect
        if (entries.length < 20 && entries.length > 0) {
            var times = Math.floor(20 / entries.length);
            var copies = [];
            while (times--) copies = copies.concat(entries);
            entries = entries.concat(copies);
        }
        var settings = {
            entries: entries,
            width: 200,
            height: 200,
            radius: '45%',
            radiusMin: 75,
            bgDraw: false,
            opacityOver: 1.00,
            opacityOut: 0.05,
            opacitySpeed: 6,
            fov: 800,
            speed: 0.1,
            fontFamily: 'Oswald, Arial, sans-serif',
            fontSize: '18',
            fontColor: '#af0707',
            fontWeight: 'normal',
            fontStyle: 'normal',
            fontStretch: 'normal',
            fontToUpperCase: true,
            tooltipFontFamily: 'Oswald, Arial, sans-serif',
            tooltipFontSize: '13',
            tooltipFontColor: 'red',
            tooltipFontWeight: 'normal',
            tooltipFontStyle: 'normal',
            tooltipFontStretch: 'normal',
            tooltipFontToUpperCase: false,
            tooltipTextAnchor: 'left',
            tooltipDiffX: 0,
            tooltipDiffY: 10
        };

        $s('#keyword-cloud').svg3DTagCloud(settings);
    }

    // get current location
    var lng = null;
    var lat = null;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            $s('#locating-position').hide();
            $s('#location-got').show();
            lng = pos.coords.longitude;
            lat = pos.coords.latitude;
        });
    }

    // show my mission
    $s('#my-mission').click(function() {
        bootbox.dialog({
            size: 'large',
            title: '不忘初心，牢记使命',
            message: '<p><img src="' + striverboardParams.urls.imgMission + '" class="w-100" alt="中国共产党人的使命"></p><p><strong class="red-text">' + striverboardParams.realName + '，别忘了你的初心和使命是：</strong></p><blockquote style="text-indent: 2em;">' + $s(this).attr('data-content') + '</blockquote>',
            buttons: {
                ok: {
                    label: '我记住了！',
                    className: 'btn-red'
                }
            }
        });
    });

    // file manager
    var chooseFile, uploaderLoaded = false,
        imgs = [];
    $s('#choose-file-modal').on('shown.bs.modal', function() {
        if (!uploaderLoaded) {
            CKFinder.widget('choose-file', {
                onInit: function(finder) {
                    $s('#set-attachments').fadeIn();
                    chooseFile = finder;
                    uploaderLoaded = true;
                }
            });
        }
    });
    $s('#set-attachments').click(function() {
        var files = chooseFile.request('files:getSelected');
        imgs = [];
        files.forEach(function(file) {
            imgs.push(file.getUrl());
        });
        $s('#picture-count').text(imgs.length ? (imgs.length + '张') : '');
    });

    // choose if its public
    $s('#moment-visibility-option .dropdown-item').click(function() {
        $s('#moment-visbility-option .dropdown-item').removeClass('active');
        $s(this).addClass('active');
        $s('#moment-visibility-text').text($s(this).text());

    });
    // choose if its a achieved moment
    $s('#moment-achieved-option .dropdown-item').click(function() {
        $s('#moment-achieved-option .dropdown-item').removeClass('active');
        $s(this).addClass('active');
        $s('#moment-achieved-text').text($s(this).text());
    });

    // post a moment
    $s('#new-moment-confirm').click(function() {
        $s('#field-choose').modal('hide');
        $s('#new-moment-loading').show();
        $s('#new-moment-icon').hide();
        $s('#new-moment').attr('disabled', 'disabled');
        var data = {
            lng: lng,
            lat: lat,
            visibility: $s('#moment-visibility-option .dropdown-item.active').attr('data-visibility'),
            achieved: $s('#moment-achieved-option .dropdown-item.active').attr('data-achieved'),
            imgs: imgs,
            description: $s('#moment-content').val(),
            field: $s('#moment-field').val()
        };
        $s.ajax({
            url: striverboardParams.urls.ajaxPostMoment,
            method: 'POST',
            data: data,
            dataType: 'json',
            complete: function() {
                $s('#new-moment-loading').hide();
                $s('#new-moment-icon').show();
                $s('#new-moment').removeAttr('disabled');
            },
            error: function() {
                toastr.error('发表失败，未知错误。');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('恭喜，发表成功！');
                    var attrs = {
                        achieved: parseInt(data.achieved),
                        visibility: data.visibility,
                        imgs: data.imgs,
                        description: data.description,
                        field: data.field,
                        time: (new Date()).getTime() / 1000,
                        realName: striverboardParams.realName
                    };
                    if (!timelineView) {
                        $s('#pre-moments').after(card(attrs));
                        $grid.masonry('reloadItems');
                        $grid.masonry('layout');
                        $grid.imagesLoaded().progress(function() {
                            $grid.masonry();
                        });
                        $s('html, body').animate({ scrollTop: $s('#pre-moments').offset().top - 100 });
                    } else {
                        $s('#pre-timeline').after(card(attrs));
                        sk.refresh();
                        $s('html, body').animate({ scrollTop: $s('#pre-timeline').offset().top - 100 });
                    }
                    $s('#moment-content').val('');
                    imgs = [];
                    $s('#picture-count').text('');
                    if (chooseFile) {
                        chooseFile.request('files:deselectAll');
                    }
                } else {
                    switch (response.message) {
                        case 'photoNumber':
                            toastr.error('选中的照片过多。请将照片总数控制在' + striverboardParams.photoNumberLimit + '以内～');
                            break;
                        case 'description':
                            toastr.error('点滴内容不可为空。');
                            break;
                        default:
                            toastr.error('发表失败，未知错误。');
                    }
                }
            }
        });
    });
});