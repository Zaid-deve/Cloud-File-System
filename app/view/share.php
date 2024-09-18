<?php

$showNavToggle = true;
require_once "../config/autoload.php";
require_once "../includes/layout/head.php";

// validate sharing
$data = $_GET['data'] or header("Location:404") or die('Someting went wrong !');

$shareType = $_GET['shareType'] ?? 'file';
if ($shareType === 'file') {
    header("Location:file.php?fileId=" . $data);
    die();
}

?>


<link rel="stylesheet" href="../styles/layout/header.css">
<link rel="stylesheet" href="../styles/layout/sidebar.css">
<link rel="stylesheet" href="../styles/index.css">
</head>

<body>

    <!-- BODY -->

    <!-- header -->
    <?php
    require_once "../includes/loader.php";
    require_once "../includes/layout/header.php";
    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";
    ?>


    <div class="container-fluid p-0 h-100">
        <div class="row g-0 m-0 h-100">
            <div class="col-12 col-md-5 col-lg-4 h-100 ps-md-3 py-md-3 sidebar-wrapper">
                <?php require_once "../includes/layout/sidebar.php" ?>
            </div>
            <div class="col h-100 py-4 overflow-scroll content-tab">
                <div class="container px-4">
                    <div class="text-center bg-white rounded-4 p-3">
                        <button class="btn bg-light-color btn-rounded lg">
                            <i class="fa-solid fa-link icon-md prime-color"></i>
                        </button>
                        <p class="text-warning fw-bold mt-3 mb-1 shared-files-count"></p>
                        <small>If you find any inapprpriate content on this shared folder, please report us <a href="#">report</a></small>
                    </div>
                </div>
                <div class="container px-4 mt-3">
                    <div class="d-flex ycenter flex-wrap bg-white rounded-4 p-3 gap-3">
                        <div class="file-searchbar">
                            <div class="d-flex flex-center border border-2 border-light rounded-5 overflow-hidden">
                                <i class="fa-solid fa-magnifying-glass icon-sm ps-3"></i>
                                <input type="text" id="file-search-inp" placeholder="Search file heare..." class="form-control border-0 w-100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container px-4 mt-3">
                    <div class="files-container">
                        <div class="all-files-container mt-3">
                            <!-- General/All Files Section -->
                            <div class="card border-0 rounded-4" style="overflow: hidden;">
                                <div class="card-header bg-white py-3 px-4">
                                    <div class="d-flex ycenter">
                                        <div class="me-auto">
                                            <i class="fa-solid fa-folder-open icon-normal"></i>
                                            <span class="ms-2 fw-bold">Shared Files</span>
                                        </div>
                                        <button class="btn btn-rounded btn-check-all">
                                            <i class="fa-regular fa-square-check icon-lg prime-color"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body all-files-body p-4">
                                    <?php include "../includes/bs5loader.php" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- file options menu -->
        <div class="menu-list position-fixed shadow rounded-4 overflow-hidden bg-white p-3">
            <ul class="list-group d-flex flex-column gap-1">
                <li class="list-group-item border-0 rounded-5" data-action="edit">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-file-pen icon-normal"></i>
                        <span>Edit file</span>
                    </div>
                </li>
                <li class="list-group-item border-0 rounded-5" data-action="share">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-share icon-normal"></i>
                        <span>Share file</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script src="../js/config/config.js"></script>
    <script src="../js/loader.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/file/functions.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/file/file.js"></script>
    <script src="../js/img.js"></script>
    <script src="../js/file/search.js"></script>

</body>

</html>