<?php

require_once "../config/autoload.php";
require_once "../php/b2/b2file.php";
$fileId = $_GET['fileId'] ?? null;
if (!$fileId) {
    header("Location:" . $_SERVER['HTTP_REFERER'] ?? "/cfs/app/");
    die();
}

// file
$b2 = new B2File();
$fileMeta = getFile($db, $fileId);
$fileMeta['downloadUrl'] = $b2->getDownloadUrl($fileMeta['x_bz_name']);
if (!$fileMeta) {
    die('The File You Are Trying To View Is Deleted Or Dosent Exists !');
}

$fileOwner = $fileMeta['file_uploader'];
$isOwner = $fileOwner == "{$authType}_$uid";
$isPrivate = $fileMeta['visibility'] == 1;
if ($isPrivate && !$isOwner) {
    die("Something Went Wrong, [The File Is Private ]");
}
unset($fileMeta['file_uploader']);

$fd = explode("/", $fileMeta['type']);
$isTxt = $fd[0] === 'text' || array_search($fd[1] ?? '', ['txt', 'json', 'xml', 'html']);

require_once "../includes/layout/head.php";

?>
<link rel="stylesheet" href="../styles/layout/header.css">
<style>
    .file-name {
        display: -webkit-box;
        overflow: hidden;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        ;
    }
</style>
</head>

<body class="bg-light-color">

    <!-- BODY -->

    <!-- header -->
    <?php
    require_once "../includes/loader.php";
    require_once "../includes/layout/header.php";
    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";
    ?>

    <div class="container-fluid overflow-scroll prev-container">
        <div class="card d-flex flex-column bg-dark-color overflow-auto">
            <div class="card-header">
                <div class="d-flex gap-2 align-items-center py-2 card-header-row flex-wrap row-gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-folder2-open text-light flex-shrink-0" viewBox="0 0 16 16">
                        <path d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7z" />
                    </svg>
                    <span class="text-light">&bullet;</span>
                    <div class="text-light flex-grow-1">
                        <h6 class="m-0 w-100 file-name"><?php echo $fileMeta['name'] ?></h6>
                        <small><?php echo getDiff($fileMeta['upload_time']); ?></small>
                    </div>
                    <div class="card-btns ms-auto d-flex flex-center gap-2">
                        <?php if ($isOwner) { ?>
                            <button class="btn bg-secondary has-icon rounded-5" id="btn-delete-file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-minus danger-color" viewBox="0 0 16 16">
                                    <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                                    <path d="M11 11.5a.5.5 0 0 1 .5-.5h4a.5.5 0 1 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                </svg>
                                <span class="fw-normal" style="color: var(--color--danger);">Delete</span>
                            </button>
                        <?php } ?>
                        <button class="btn bg-secondary btn-rounded btn-lg has-icon rounded-5" id="btn-share-file">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-share-fill light-color" viewBox="0 0 16 16">
                                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex-grow-1 px-3 py-1 light-color overflow-auto" style="height: 340px;border-top:1px solid #42455a">
                <div id="file-prev-container" class=" h-100">
                    <?php require_once "../includes/bs5loader.php"; ?>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <p class="m-0 light-color"></p>
                    <button class="btn bg-secondary-color rounded-5 has-icon ms-auto" id="btn-download-file">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download icon-svg" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                        </svg>
                        <span class="fw-normal">Download</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script src="../js/config/config.js"></script>
    <script src="../js/loader.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/file/functions.js"></script>
    <script src="../js/file/download.js"></script>
    <?php

    echo "<script>const FILE = " . json_encode($fileMeta) . "</script>";

    // update recent timer
    if ($isOwner) {
        $stmt = $db->qry("UPDATE file_uploads SET file_last_viewed = CURRENT_TIMESTAMP() WHERE file_id = ?", [$fileMeta['id']]);
    }

    ?>

    <script src="../js/file/view.js"></script>

</body>

</html>