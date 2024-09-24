<?php
require_once "../config/autoload.php";

$fileId = isset($_GET['fileId']) ? $_GET['fileId'] : null;
if (!$fileId) {
    die("Someting Went Wrong, File Missing !");
}

$file = getFile($db, $fileId);
if (!$file) {
    die('The File You Are Requesting Dosent Exists, Or Has Been Deleted !');
}

$filename = $file['name'];
if (strlen($filename) > 100) {
    $filename = substr($filename, 0, 100) . "...";
}
$filesize = formatBytes($file['size'], 1);
$timeAgo = getDiff($file['upload_time']);
// $btns = "";

// if ($file['file_uploader'] === $uid) {
//     $btns = "<button"
// }

require_once "../includes/layout/head.php";
?>

<link rel="stylesheet" href="/cfs/app/styles/file.css">
</head>

<body class="bg-light-color">

    <!-- BODY -->

    <?php

    require_once "../includes/layout/header.php";
    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";

    ?>

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-8 col-lg-6 mx-auto">
                <div class="card border-dark overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4 text-center bg-light pt-4 file-prev-col">
                            <i class="fa-solid fa-file file-icon"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $filename ?></h6>
                                <p class="card-text"><?php echo $filesize . " &bullet; " . $timeAgo ?></p>

                                <!-- place buttons as per the user -->
                                <div class="mt-3">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-danger has-icon flex-grow-1 rounded-5">
                                            <i class="fa-solid fa-trash"></i>
                                            <span class="fw-bold">Delete File</span>
                                        </button>

                                        <button class="btn bg-prime-color has-icon flex-grow-1 rounded-5">
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                            <span class="fw-bold">Download</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- <?php echo $btns; ?> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script src="../js/config/config.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/img.js"></script>
    <script src="../js/file/functions.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/user/account.js"></script>

</body>

</html>