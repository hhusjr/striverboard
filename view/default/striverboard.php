<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
$params = new stdClass;
$params->subTitle = '奋斗墙';
$params->css = ['css/striverboard.css'];
if ($a->timelineView) {
    $params->css[] = 'libs/jazz-timeline/css/jazz-timeline.css';
}
($a->show)('include/header', $params);
?>
<div<?php echo ($a->timelineView) ? ' id="skrollr-body"' : ''; ?>>
    <div class="container-fluid p-0">
        <div class="jumbotron m-0 w-100">
            <div class="row no-gutters content">
                <div class="col-lg-7 col-md-8">
                    <?php
                if ($a->user) {
                    ?>
                    <a href="<?php ($a->U)('Striverboard', 'Index', [
                    'timeline' => $a->timelineView,
                    'uid' => ($a->user->uid == $a->uid ? 0 : $a->user->uid),
                    'fid' => $a->field
                ]); ?>" class="btn btn-orange btn-lg d-inline-block p-3"><i
                            class="oi oi-<?php echo ($a->user->uid == $a->uid) ? 'eye' : 'home'; ?> action-icon"></i></a>
                    <?php
                }
                ?>
                    <a href="<?php ($a->U)('Striverboard', 'Index', [
                    'timeline' => !$a->timelineView,
                    'uid' => $a->uid,
                    'fid' => $a->field
                ]); ?>" class="btn btn-orange btn-lg d-inline-block p-3"><i
                            class="oi oi-<?php echo $a->timelineView ? 'list' : 'clock'; ?> action-icon"></i></a>
                    <?php
                if ($a->user) {
                    ?>
                    <button class="btn btn-orange btn-lg d-inline-block p-3" data-target="#field-choose"
                        data-toggle="modal" id="new-moment">
                        <i class="oi oi-plus action-icon" id="new-moment-icon"></i>
                        <span class="spinner-border" style="display: none;" id="new-moment-loading" role="status"
                            aria-hidden="true"></span>
                    </button>
                    <?php
                }
                ?>
                    <button class="btn btn-orange btn-lg d-inline-block p-3" data-target="#show-mode-choose"
                        data-toggle="modal" id="show-mode">
                        <i class="oi oi-eye action-icon" id="show-mode-icon"></i>
                    </button>
                    <div class="moment-container view">
                        <textarea class="form-control z-depth-1 moment-content" id="moment-content"
                            placeholder="记录我的奋斗点滴"></textarea>
                        <div class="navbar navbar-expand-md moment-footer" id="moment-footer">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#moment-footer-navbar" aria-controls="moment-footer-navbar"
                                aria-expanded="false" aria-label="展开/折叠菜单">
                                <span class="oi oi-plus red-text"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="moment-footer-navbar">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                        <a class="nav-link red-text" role="button" data-toggle="modal"
                                            data-target="#choose-file-modal"><i class="oi oi-camera-slr"></i>
                                            <span id="picture-count"></span>照片
                                        </a>
                                    </li>
                                    <li class="nav-item dropup">
                                        <a role="button" class="nav-link dropdown-toggle red-text"
                                            id="moment-visibility" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"><i class="oi oi-eye"></i> <span
                                                id="moment-visibility-text">公开</span></a>
                                        <div class="dropdown-menu dropdown-primary" aria-labelledby="moment-visibility"
                                            id="moment-visibility-option">
                                            <a class="dropdown-item active" role="button"
                                                data-visibility="public">公开</a>
                                            <a class="dropdown-item" role="button" data-visibility="private">私有</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropup">
                                        <a class="nav-link dropdown-toggle red-text" role="button" id="moment-target"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="oi oi-target"></i> <span id="moment-achieved-text">已实现</span></a>
                                        <div class="dropdown-menu dropdown-primary" aria-labelledby="moment-target"
                                            id="moment-achieved-option">
                                            <a class="dropdown-item active" data-achieved="1" role="button">已实现</a>
                                            <a class="dropdown-item" data-achieved="0" role="button">仍是目标</a>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item"><a role="button" class="nav-link red-text" id="my-mission"
                                            data-content="<?php echo $a->user ? $a->user->mission : ''; ?>"><i
                                                class="oi oi-heart"></i> 查看初心与使命</a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="spinner-grow red-text" role="status" id="locating-position">
                                            <span class="sr-only">定位中...</span>
                                        </div>
                                    </li>
                                    <li class="nav-item" id="location-got" style="display: none;">
                                        <a href="#" class="nav-link red-text"><i class="oi oi-location"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    if (!$a->user) {
                        ?>
                        <div class="mask flex-center rgba-white-strong">
                            <p>请先<a data-target="#login-modal" data-toggle="modal" class="red-text">登陆</a></p>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4 d-flex justify-content-center justify-content-md-end pr-0 pr-lg-5">
                    <div id="keyword-cloud"></div>
                </div>
            </div>
        </div>
        <div class="moments py-2" id="moments-wrapper">
            <div class="container">
                <div class="jazz-timeline" id="timeline-view">
                    <div id="pre-timeline"></div>
                </div>
                <div class="grid" id="grid-view">
                    <div class="grid-sizer col-lg-4 col-md-6" id="pre-moments"></div>
                    <div class="grid-item col-lg-4 col-md-6" id="loading-moments">
                        <div class="card">
                            <div class="d-flex justify-content-center p-5">
                                <div class="spinner-border" role="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="continue-load" class="btn btn-orange btn-block my-3">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    加载中...
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade top" id="choose-file-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-frame modal-top" role="document">
            <div class="modal-content">
                <div class="modal-body p-0" style="min-height: 100px;">
                    <div id="choose-file">
                        <div class="d-flex justify-content-center mt-3">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" id="set-attachments"
                        style="display: none;">附选中图</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="field-choose" tabindex="-1" role="dialog" aria-labelledby="field-choose"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="heading lead">快要成功啦！</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="md-form">
                        <i class="oi oi-check red-text prefix animated rotateIn"></i>
                        <select id="moment-field" class="mt-5 mb-0 browser-default custom-select md-form" required>
                            <?php
                                foreach ($a->fields as $field) {
                                    printf('<option value="%d">%s</option>', $field->fid, $field->name);
                                }
                            ?>
                        </select>
                        <label for="moment-field">该奋斗点滴的相关领域</label>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" id="new-moment-confirm"><span
                            class="oi oi-plus"></span>
                        现在发布</button>
                    <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="show-mode-choose" tabindex="-1" role="dialog" aria-labelledby="field-choose"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="heading lead">选择你感兴趣的领域</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <form method="get" action="<?php ($a->U)('Striverboard', 'Index', [
                    'timeline' => !$a->timelineView,
                    'uid' => $a->uid
                ]); ?>">
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="oi oi-eye display-4 red-text prefix animated rotateIn"></i>
                        </div>
                        <div class="md-form">
                            <select id="show-mode-field" class="mt-5 mb-0 browser-default custom-select md-form"
                                name="fid">
                                <option value="0">全部</option>
                                <?php
                                foreach ($a->fields as $field) {
                                    printf('<option value="%d"%s>%s</option>', $field->fid, ($a->field == $field->fid ? ' selected' : ''), $field->name);
                                }
                            ?>
                            </select>
                            <label for="show-mode-field">现在我只关注如下领域的奋斗点滴：</label>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger" id="show-mode-submit"><span
                                class="oi oi-check"></span>
                            确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var striverboardParams = {
        urls: {
            imgMission: '<?php ($a->S)('imgs/president_mission.jpg'); ?>',
            ajaxPostMoment: '<?php ($a->U)('Striverboard', 'AjaxPostMoment'); ?>',
            ajaxMoments: '<?php ($a->U)('Striverboard', 'AjaxMoments'); ?>',
            ajaxLike: '<?php echo ($a->U)('Striverboard', 'AjaxLike'); ?>',
            momentDetail: '<?php echo ($a->U)('Striverboard', 'MomentDetail'); ?>?mid='
        },
        missionWords: JSON.parse(
            '<?php echo json_encode($a->missionWords); ?>'),
        realName: '<?php echo $a->user ? $a->user->realName : 'Unknown'; ?>',
        timelineView: '<?php echo $a->timelineView; ?>',
        showUid: '<?php echo $a->uid; ?>',
        significant: '<?php echo $a->significant; ?>',
        achieved: '<?php echo $a->achieved === false ? -1 : $a->achieved; ?>',
        field: '<?php echo $a->field; ?>'
    };
</script>
<?php
$params = new stdClass;
$params->js = [
    'libs/mdb/js/addons/masonry.pkgd.min.js',
    'libs/mdb/js/addons/imagesloaded.pkgd.min.js',
    'libs/svg3dtagcloud/svg3dtagcloud.js',
    'libs/ckfinder/ckfinder.js'
];
if ($a->timelineView) {
    $params->js[] = 'libs/jazz-timeline/js/skrollr.min.js';
}
$params->js[] = 'js/striverboard.js';
($a->show)('include/footer', $params);
