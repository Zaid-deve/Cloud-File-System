<?php

$showNavToggle = true;
require_once "config/autoload.php";
require_once "includes/layout/head.php";
echo "<script>const ISPASSKEYSET = '" . !empty($user_passkey) . "'</script>";

?>


<link rel="stylesheet" href="styles/layout/header.css">
<link rel="stylesheet" href="styles/layout/sidebar.css">
<link rel="stylesheet" href="styles/index.css">
</head>

<body>

    <!-- BODY -->

    <!-- header -->
    <?php
    require_once "includes/loader.php";
    require_once "includes/layout/header.php";
    require_once "includes/alert.php";
    require_once "includes/notify.php";
    require_once "includes/popup.php";
    ?>


    <div class="container-fluid p-1 p-sm-2 p-md-3 pt-3 h-100">
        <div class="row g-0 m-0 h-100">
            <div class="col-12 col-md-5 col-lg-4 h-100 sidebar-wrapper">
                <?php require_once "includes/layout/sidebar.php" ?>
            </div>
            <div class="col h-100 pb-4 overflow-scroll content-tab">
                <div class="container-fluid">
                    <div class="d-flex ycenter flex-wrap bg-white rounded-4 p-3 gap-3">
                        <div class="file-searchbar">
                            <div class="d-flex flex-center border border-2 border-light rounded-5 overflow-hidden">
                                <i class="fa-solid fa-magnifying-glass icon-sm ps-3"></i>
                                <input type="text" id="file-search-inp" placeholder="Search file heare..." class="form-control border-0 w-100">
                            </div>
                        </div>

                        <div class="ms-auto d-flex gap-2 ycenter">
                            <button class="btn bg-secondary-color has-icon rounded-5" id="btn-share-folder">
                                <i class="fa-solid fa-share"></i>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="files-container">
                        <div class="recent-files-container d-none">
                            <!-- Recent Files Section -->
                            <div class="card border-0 rounded-4" style="overflow: hidden;">
                                <div class="card-header bg-white py-3 px-4">
                                    <i class="fa-solid fa-clock-rotate-left icon-normal"></i>
                                    <span class="ms-2 fw-bold">My Recent Files</span>
                                </div>
                                <div class="card-body p-4 recent-files-body">
                                    <?php include "includes/bs5loader.php" ?>
                                </div>
                            </div>
                        </div>

                        <div class="all-files-container mt-3">
                            <!-- General/All Files Section -->
                            <div class="card border-0 rounded-4" style="overflow: hidden;">
                                <div class="card-header bg-white py-3 px-4">
                                    <div class="d-flex ycenter">
                                        <div class="me-auto">
                                            <i class="fa-solid fa-folder-open icon-normal"></i>
                                            <span class="ms-2 fw-bold">My Files</span>
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
                                    <?php include "includes/bs5loader.php" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- file options menu -->
        <?php require_once "includes/layout/menu.php" ?>
    </div>


    <!-- SCRIPTS -->
    <script src="js/config/config.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/popup.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/file/functions.js"></script>
    <script src="js/file/download.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/file/file.js"></script>
    <script src="js/img.js"></script>
    <script src="js/file/search.js"></script>

</body>

</html>