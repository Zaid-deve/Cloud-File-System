<div class="menu-list position-fixed shadow rounded-4 overflow-hidden bg-white p-3">
    <ul class="list-group d-flex flex-column gap-1">
        <?php if (!isset($hideDeleteOption)) { ?>
            <li class="list-group-item border-0 rounded-5 active" data-action="delete">
                <div class="d-flex ycenter gap-2">
                    <i class="fa-solid fa-trash icon-normal"></i>
                    <span>Delete file</span>
                </div>
            </li>
        <?php } ?>

        <li class="list-group-item border-0 rounded-5" data-action="edit">
            <div class="d-flex ycenter gap-2">
                <i class="fa-solid fa-file-pen icon-normal"></i>
                <span>Rename File</span>
            </div>
        </li>

        <li class="list-group-item border-0 rounded-5" data-action="download">
            <div class="d-flex ycenter gap-2">
                <i class="fa-solid fa-file-arrow-down icon-normal"></i>
                <span>Download</span>
            </div>
        </li>

        <?php if (!isset($hideShareOption)) { ?>
            <li class="list-group-item border-0 rounded-5" data-action="share">
                <div class="d-flex ycenter gap-2">
                    <i class="fa-solid fa-share icon-normal"></i>
                    <span>Share file</span>
                </div>
            </li>
        <?php } ?>

        <?php if (!isset($hideHideOption)) { ?>
            <li class="list-group-item border-0 rounded-5" data-action="hide">
                <div class="d-flex ycenter gap-2">
                    <i class="fa-solid fa-lock icon-normal"></i>
                    <span>Hide file</span>
                </div>
            </li>
        <?php } else { ?>
            <li class="list-group-item border-0 rounded-5" data-action="unhide">
                <div class="d-flex ycenter gap-2">
                    <i class="fa-regular fa-eye icon-normal"></i>
                    <span>Remove From Safe</span>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>