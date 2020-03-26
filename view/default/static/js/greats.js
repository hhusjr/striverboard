$s(document).ready(function() {
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