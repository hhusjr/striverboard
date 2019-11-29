<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '伟大的奋斗点滴';
$params->css = [
    'css/greats.css'
];
($a->show)('include/header', $params);
?>
<div id="greats-slide" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#greats-slide" data-slide-to="0" class="active"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div class="view">
                <img class="w-100 d-none d-lg-block"
                    src="<?php ($a->S)('imgs/greats_bg/greats_bg_lg.jpg'); ?>"
                    alt="">
                <img class="w-100 d-none d-md-block d-lg-none"
                    src="<?php ($a->S)('imgs/greats_bg/greats_bg_md.jpg'); ?>"
                    alt="">
                <img class="w-100 d-block d-md-none"
                    src="<?php ($a->S)('imgs/greats_bg/greats_bg_sm.jpg'); ?>"
                    alt="">
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#greats-slide" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">上一张</span>
    </a>
    <a class="carousel-control-next" href="#greats-slide" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">下一张</span>
    </a>
</div>
<div class="blocks">
    <div class="bg">
        <div class="block greats">
            <div class="container">
                <h1>伟大的奋斗点滴</h1>
                <div class="p-3 p-md-5">
                    <div class="row">
                        <?php
        foreach ($a->greats as $great) {
            ?>
                        <div class="col-md-6">
                            <hr>
                            <div class="media d-block d-md-flex my-4">
                                <img class="d-flex mx-auto media-image z-depth-1 mb-3 mb-md-0" style="width: 160px;"
                                    src="<?php echo $great->thumbnail; ?>"
                                    alt="伟大的奋斗点滴配图">
                                <div class="media-body ml-md-3 ml-0">
                                    <h5 class="mt-0 font-weight-bold red-text"><i class="oi oi-star"></i> <?php echo $great->name; ?>
                                    </h5>
                                    <p class="mb-1"><?php echo $great->description; ?>
                                    </p>
                                    <p class="m-0 d-flex justify-content-end">
                                        <button href="#" class="btn btn-danger btn-sm show-video"
                                            data-target="#watch-video" data-toggle="modal"
                                            data-video-url="<?php echo $great->videoUrl; ?>"
                                            data-title="<?php echo $great->name; ?>">
                                            <i class="oi oi-eye"></i>
                                            观看</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
        }
        ?>
                    </div>
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination pg-amber m-0 mt-4">
                            <?php
                            for ($i = 1; $i <= $a->pageCount; $i++) {
                                ?>
                            <li class="page-item<?php echo ($i == $a->page) ? ' active' : ''; ?>"><a class="page-link" href="<?php echo ($a->U)('Greats', 'Index', ['page' => $i]); ?>"><?php echo $i; ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="watch-video" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="heading lead" id="watch-video-title">视频标题</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <div class="modal-body mb-0 p-0" id="watch-video-body">
            </div>

            <div class="modal-footer mb-0 p-0">
                <a href="#" class="btn btn-lg btn-block btn-red" target="_blank" id="watch-video-bottom">无法播放？直接打开！</a>
            </div>
        </div>
    </div>
</div>
<?php
$params = new stdClass;
$params->js = ['js/greats.js'];
($a->show)('include/footer', $params);
