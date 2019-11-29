function createMoment(attrs) {
    var limit = 150;
    if (attrs.description.length > limit) attrs.description = attrs.description.substr(0, limit) + '...';
    var img = (attrs.imgs.length > 0) ? attrs.imgs[0] : spaceParams.urls.thumbsUpImgUrl;

    var headerImage = $s('<img class="d-flex mx-auto media-image z-depth-1 mb-3 mb-md-0" style="width: 160px;" src="' + img + '" alt="奋斗点滴配图">');
    var mediaBody = $s('<div class="media-body ml-md-3 ml-0"><h5 class="mt-0 font-weight-bold">' + attrs.realName + '说：</h5><p>' + '<span class="badge badge-pill badge-' + (attrs.achieved ? 'success">已完成' : 'danger">未完成') + '</span> ' + attrs.description + ' <a href="' + spaceParams.urls.momentDetail + attrs.mid + '" target="_blank" class="view-detail"><i class="oi oi-eye"></i></a>' + '</p><ul class="list-unstyled list-inline font-small m-0 mt-3"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-target pr-1"></i> ' + attrs.field + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-location pr-1"></i> ' + formatDistance(attrs.distance) + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1"></i> ' + formatDay(attrs.time) + '</li></ul></div>');
    var element = $s('<div class="media d-block d-md-flex my-4"></div>');
    element.append(headerImage);
    element.append(mediaBody);

    var result = $s('<div class="col-lg-6"></div>');
    result.prepend('<hr class="m-0 p-0">');
    result.append(element);

    return result;
}

function createUserCard(attrs) {
    var headerEle = $s('<h4 class="card-title d-flex"><i class="oi oi-heart mr-auto red-text" style="cursor: pointer;"></i>' + attrs.realName + '<a href="' + spaceParams.urls.userStriverboard + attrs.uid + '" class="ml-auto"><i class="oi oi-eye"></i></a></h4>');
    var locationEle = $s('<ul class="list-unstyled list-inline font-small m-0"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-home pr-1"> ' + attrs.institution + '</i></li></ul>');
    var missionEle = $s('<p class="card-text">' + attrs.mission + '</p>');
    var infoEle = $s('<ul class="list-unstyled list-inline font-small m-0"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-audio pr-1"></i>' + (Math.floor(attrs.similarity * 1000) / 10) + '%</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-target pr-1"></i>' + attrs.field + '</li></ul>');
    var body = $s('<div class="card-body"></div>');
    body
        .append(headerEle)
        .append(locationEle)
        .append(missionEle)
        .append(infoEle);
    var card = $s('<div class="card"></div>');
    card.append(body);
    var result = $s('<div class="grid-item col-lg-3 col-md-4 py-3"></div>');
    result.append(card);
    return result;
}

var inited = false;
var $grid;

function showUsers(keyword = null) {
    $s.ajax({
        url: spaceParams.urls.ajaxSearchUsers,
        method: 'POST',
        data: {
            keyword: keyword
        },
        dataType: 'json',
        success: function(users) {
            $s('#loading-users').fadeOut();
            $s('#users-container').empty();
            $s('#users-container').append('<div class="grid-sizer col-lg-3 col-md-4"></div>');
            users.forEach(function(user) {
                $s('#users-container').append(createUserCard(user));
            });
            if (inited) {
                $grid.masonry('reloadItems');
                $grid.masonry('layout');
            } else {
                // init Masonry
                $grid = $s('.grid').masonry({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    columnWidth: '.grid-sizer'
                });
                inited = true;
            }
        }
    });
}

$s(document).ready(function() {
    // get users
    showUsers();
    $s('#search-users').keyup(function() {
        showUsers($s('#search-users').val());
    });

    // get nearby moments
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            $s.ajax({
                url: spaceParams.urls.ajaxNearestMoments,
                method: 'POST',
                dataType: 'json',
                data: {
                    lng: pos.coords.longitude,
                    lat: pos.coords.latitude
                },
                success: function(moments) {
                    $s('#loading-moments').fadeOut();
                    moments.forEach(function(attrs) {
                        $s('#moments').append(createMoment(attrs));
                    });
                }
            });
        });
    }
});