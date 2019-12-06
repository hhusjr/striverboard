var page = 1;
var finished = false;
var momentsCount = 0;
var timelineView = striverboardParams.timelineView;
var lastRequestTime = 0;
var loadOk = true;
var $grid;

function card(attrs) {
    momentsCount++;
    var limit = 100;
    if (attrs.description.length > limit) attrs.description = attrs.description.substr(0, limit) + '...';

    var slide = $s('<div class="carousel slide moment-slides" data-interval="0" data-ride="carousel" id="moment' + momentsCount + '-slider"></div>');
    var inner = $s('<div class="carousel-inner"></div>');
    var imgs = attrs.imgs;
    imgs.forEach(function(img) {
        inner.append('<div class="carousel-item"><img class="d-block w-100" src="' + img + '" alt="奋斗点滴配图"></div>');
    });
    inner.children(':first').addClass('active');
    slide.append(inner);
    slide.append('<a class="carousel-control-prev" href="#moment' + momentsCount + '-slider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">上一张</span></a><a class="carousel-control-next" href="#moment' + momentsCount + '-slider" role="button"data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">下一张</span></a>');

    var card = $s('<div class="card"></div>');
    if (attrs.significant) card.addClass('moment-important');

    if (imgs.length) card.append(slide);

    var body = $s('<div class="card-body"></div>');
    if (striverboardParams.loggedIn) {
        var likeElement = '<a role="button" class="add-like" data-like="' + (attrs.liked ? 1 : 0) + '" data-mid="' + attrs.mid + '"><i class="thumb-up-like oi oi-thumb-up pr-1' + (attrs.liked ? ' red-text' : '') + '"></i> <span class="like-count">' + attrs.likes + '</span></a>';
    } else {
        var likeElement = '';
    }
    body.append('<p class="card-text black-text"><span class="badge badge-pill badge-' + (attrs.achieved ? 'success">已完成' : 'danger">未完成') + '</span> ' + htmlspecialchars(attrs.description) + (striverboardParams.loggedIn ? ' <a href="' + striverboardParams.urls.momentDetail + attrs.mid + '" target="_blank" class="view-detail"><i class="oi oi-eye"></i></a>' : '') + '</p>');
    body.append('<ul class="list-unstyled list-inline font-small m-0"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1"></i> ' + formatDay(attrs.time) + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-person pr-1"></i> ' + attrs.realName + '</li><li class="list-inline-item pr-2 grey-text">' + likeElement + '</li></ul>');
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

    element.find('.add-like').click(function() {
        var me = $s(this);

        if (parseInt(me.attr('data-like'))) return;
        me.attr('data-like', 1);

        var mid = me.attr('data-mid');
        $s.ajax({
            url: striverboardParams.urls.ajaxLike,
            data: {
                mid: mid
            },
            dataType: 'json',
            method: 'POST',
            success: function(response) {
                if (!response.success) {
                    toastr.error('该奋斗点滴无法点赞。可能由于它是私有的奋斗点滴，或者你已经点过赞。');
                    return;
                }
                me.children('.thumb-up-like').addClass('red-text');
                var countElement = me.children('.like-count');
                countElement.text(parseInt(countElement.text()) + 1);
            },
            error: function() {
                toastr.error('无法点赞，未知错误。');
            }
        });
    });

    return element;
}

function onMomentsLoaded() {
    if (!timelineView) {
        $s('#loading-moments').fadeOut(function() {
            $grid.masonry('reloadItems');
            $grid.masonry('layout');
        });
    } else {
        if (loadSk) {
            sk.refresh();
        }
    }
}

function loadMoments() {
    if (finished) return;
    var currentTime = new Date().getTime();
    if (!loadOk || currentTime - lastRequestTime < 500) return;
    lastRequestTime = currentTime;
    loadOk = false;
    if (!timelineView) $s('#loading-moments').fadeIn();

    $s('#continue-load').attr('disabled', 'disabled');
    $s('#continue-load .spinner-border').fadeIn();
    $s('#continue-load .loading-text').text('加载中...');

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
            loadOk = true;
            $s('#continue-load .spinner-border').fadeOut();
            if (!moments.length) {
                finished = true;
                $s('#continue-load .loading-text').text('到底啦！');
                $s('#continue-load').attr('disabled', 'disabled');
                toastr.success('奋斗点滴全部加载完了哦～');
                if (!timelineView) $s('#loading-moments').fadeOut();
                onMomentsLoaded();
                return;
            }
            $s('#continue-load .loading-text').text('继续加载');
            moments.forEach(function(moment) {
                if (!timelineView) $s('#loading-moments').before(card(moment));
                else $s('#timeline-view').append(card(moment));
            });
            $s('#continue-load').removeAttr('disabled');
            onMomentsLoaded();
        }
    });
    page++;
}

var sk, loadSk = false;

$s(document).ready(function() {
    // hide a view
    if (timelineView) {
        $s('#grid-view').hide();
        sk = skrollr.init({ forceHeight: false });
        if (sk.isMobile()) {
            sk.destroy();
        } else loadSk = true;
    } else {
        $s('#timeline-view').hide();
        // when slide, relayout
        $s(document).on('slid.bs.carousel', '.moment-slides', function() {
            $grid.masonry('reloadItems');
            $grid.masonry('layout');
        });
    }

    // init Masonry
    $grid = $s('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });

    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function() {
        $grid.masonry();
    });

    // load moments and scrolling to show more
    loadMoments();
    $s(window).scroll(function() {
        if (finished) return;
        if ($s(document).height() - $s(this).height() - $s(this).scrollTop() < 1) {
            loadMoments();
        }
    });
    $s('#continue-load').click(function() {
        if (finished) return;
        loadMoments();
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
            message: '<p><img src="' + striverboardParams.urls.imgMission + '" class="w-100" alt="中国共产党人的使命"></p><p><strong class="red-text">' + striverboardParams.realName + '，别忘了你的初心和使命是：</strong></p><blockquote style="text-indent: 2em;">' + htmlspecialchars($s(this).attr('data-content')) + '</blockquote>',
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
        $s('#moment-visibility-option .dropdown-item').removeClass('active');
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
                        realName: striverboardParams.realName,
                        liked: false,
                        likes: 0,
                        mid: response.mid
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
                            toastr.error('点滴内容的字数应该在3～800内。');
                            break;
                        default:
                            toastr.error('发表失败，未知错误。');
                    }
                }
            }
        });
    });
});