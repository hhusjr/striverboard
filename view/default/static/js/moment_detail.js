$s(document).ready(function() {
    $s('#moment-time').text(' ' + formatDay($s('#moment-time').attr('data-time')));

    // show images
    $s(document).on('click', '[data-toggle="lightbox"]', function(e) {
        e.preventDefault();
        $s(this).ekkoLightbox();
    });

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

    // add like
    $s('.add-like').click(function() {
        var me = $s(this);

        if (parseInt(me.attr('data-like'))) return;
        me.attr('data-like', 1);

        var mid = me.attr('data-mid');
        $s.ajax({
            url: momentDetailParams.urls.ajaxLike,
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
});