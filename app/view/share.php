<?php

$showNavToggle = true;
require_once "../config/autoload.php";
require_once "../includes/layout/head.php";

// validate sharing
$data = $_GET['data'] or header("Location:404") or die('Something went wrong!');

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


    <div class="container-fluid p-1 p-sm-2 p-md-3 pt-3 h-100">
        <div class="row g-0 m-0 h-100">
            <div class="col-12 col-md-5 col-lg-4 h-100 sidebar-wrapper">
                <?php require_once "../includes/layout/sidebar.php" ?>
            </div>
            <div class="col h-100 pb-4 overflow-scroll content-tab">
                <div class="container-fluid">
                    <div class="text-center bg-white rounded-4 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-folder-symlink secondary-color" viewBox="0 0 16 16">
                            <path d="m11.798 8.271-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742" />
                            <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m.694 2.09A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09l-.636 7a1 1 0 0 1-.996.91H2.826a1 1 0 0 1-.995-.91zM6.172 2a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                        </svg>
                        <p class="secondary-color fw-bold mt-3 mb-1 shared-files-count"></p>
                        <small class="text-muted">If you find any inappropriate content in this shared folder, please <a href="#">report</a>.</small>
                    </div>
                </div>
                <div class="container-fluid mt-3">
                    <div class="d-flex ycenter flex-wrap bg-white rounded-4 p-3 gap-3">
                        <div class="file-searchbar">
                            <div class="d-flex flex-center border border-2 border-light rounded-5 overflow-hidden">
                                <i class="fa-solid fa-magnifying-glass icon-sm ps-3"></i>
                                <input type="text" id="file-search-inp" placeholder="Search file here..." class="form-control border-0 w-100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-3">
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
                                        <button class="btn bg-light-color has-icon btn-check-all rounded-5 ms-2 d-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-check icon-svg" viewBox="0 0 16 16">
                                                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                                                <path d="M15.854 10.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.707 0l-1.5-1.5a.5.5 0 0 1 .707-.708l1.146 1.147 2.646-2.647a.5.5 0 0 1 .708 0" />
                                            </svg>
                                            <span class="dark-color fw-normal">select all</span>
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
        <?php

        $hideDeleteOption = $hideHideOption = true;
        require_once "../includes/layout/menu.php";

        ?>
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