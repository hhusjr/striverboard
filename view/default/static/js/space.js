function createMoment(attrs) {
    var limit = 400;
    if (attrs.description.length > limit) attrs.description = attrs.description.substr(0, limit) + '...';
    var img = (attrs.imgs.length > 0) ? attrs.imgs[0] : spaceParams.urls.thumbsUpImgUrl;

    var headerImage = $s('<img class="d-flex mb-3 mx-auto media-image z-depth-1" style="width: 160px;" src="' + img + '" alt="奋斗点滴配图">');
    var mediaBody = $s('<div class="media-body text-center text-md-left ml-md-3 ml-0"><h5 class="mt-0 font-weight-bold">' + attrs.realName + '说：</h5><p>' + '<span class="badge badge-pill badge-' + (attrs.achieved ? 'success">已完成' : 'danger">未完成') + '</span> ' + attrs.description + '</p><ul class="list-unstyled list-inline font-small m-0 mt-3"><li class="list-inline-item pr-2 grey-text"><i class="oi oi-target pr-1"></i> ' + attrs.field + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-location pr-1"></i> ' + formatDistance(attrs.distance) + '</li><li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1"></i> ' + formatDay(attrs.time) + '</li></ul></div>');
    var element = $s('<div class="media d-block d-md-flex mt-4"></div>');
    element.append(headerImage);
    element.append(mediaBody);

    var result = $s('<div class="col-lg-6"></div>');
    result.append(element);

    return result;
}

$s(document).ready(function() {
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