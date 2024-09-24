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


    <div class="container-fluid p-0 h-100">
        <div class="row g-0 m-0 h-100">
            <div class="col-12 col-md-5 col-lg-4 h-100 ps-md-3 py-md-3 sidebar-wrapper">
                <?php require_once "includes/layout/sidebar.php" ?>
            </div>
            <div class="col h-100 py-4 overflow-scroll content-tab">
                <div class="container px-4">
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
                <div class="container px-4 mt-3">
                    <div class="files-container">
                        <div class="recent-files-container">
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
                                        <button class="btn btn-rounded btn-check-all">
                                            <i class="fa-regular fa-square-check icon-lg prime-color"></i>
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