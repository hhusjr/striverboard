<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '点滴详情';
$params->css = [
    'libs/lightbox/ekko-lightbox.css',
    'css/main.css',
    'css/moment_detail.css'
];
($a->show)('include/header', $params);
?>
<div class="container">
    <div class="moment-detail-container p-3 p-md-5">
        <div class="mb-3">
            <div class="grid">
                <div class="grid-sizer col-lg-2 col-md-3"></div>
                <?php
                foreach ($a->imgs as $img) {
                    ?>
                <div class="grid-item col-lg-2 col-md-3 p-1">
                    <a href="<?php echo $img; ?>"
                        data-toggle="lightbox">
                        <img src="<?php echo $img; ?>"
                            style="width: 100%;" alt="奋斗点滴配图" class="z-depth-1">
                    </a>
                </div>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="moment-description mb-3"><?php echo htmlspecialchars($a->description); ?>
        </div>
        <div class="d-flex">
            <ul class="list-unstyled list-inline font-small m-0 mr-auto">
                <li class="list-inline-item pr-2 grey-text"><i class="oi oi-calendar pr-1" id="moment-time"
                        data-time="<?php echo $a->time; ?>"></i>
                </li>
                <li class="list-inline-item pr-2 grey-text"><i class="oi oi-person pr-1"></i> <?php echo $a->realName; ?>
                </li>
            </ul>
            <div class="ml-auto">
                <a role="button" class="grey-text add-like"
                    data-like="<?php echo $a->liked ? '1' : '0'; ?>"
                    data-mid="<?php echo $a->mid; ?>">
                    <i
                        class="thumb-up-like oi oi-thumb-up pr-1<?php echo $a->liked ? ' red-text' : ''; ?>"></i>
                    <span class="like-count"><?php echo $a->likes; ?></span>
                </a>
            </div>
        </div>
        <hr>
        <h3 style="color: #a00808;">回复</h3>
        <textarea class="form-control z-depth-1" style="height: 100px;" id="reply-content"
            placeholder="奋斗点滴回复功能尚未开放，敬请期待！"></textarea>
    </div>
</div>
<script>
    var momentDetailParams = {
        urls: {
            ajaxLike: '<?php echo($a->U)('Striverboard', 'AjaxLike'); ?>'
        }
    };
</script>
<?php
$params = new stdClass;
$params->js = [
    'libs/mdb/js/addons/masonry.pkgd.min.js',
    'libs/mdb/js/addons/imagesloaded.pkgd.min.js',
    'libs/lightbox/ekko-lightbox.min.js',
    'js/moment_detail.js'
];
($a->show)('include/footer', $params);
