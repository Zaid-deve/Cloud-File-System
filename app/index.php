<?php

$showNavToggle = true;
require_once "config/autoload.php";

require_once "includes/layout/head.php";

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
            <div class="col h-100 py-4 overflow-scroll">
                <div class="container px-4">
                    <div class="d-flex ycenter flex-wrap bg-white rounded-4 p-3 gap-3">
                        <div class="file-searchbar">
                            <div class="d-flex flex-center border border-2 border-light rounded-5 overflow-hidden">
                                <i class="fa-solid fa-magnifying-glass icon-sm ps-3"></i>
                                <input type="text" id="file-search-inp" placeholder="Search file heare..." class="form-control border-0 w-100">
                            </div>
                        </div>

                        <div class="ms-auto d-flex gap-2 ycenter">
                            <button class="btn bg-secondary-color has-icon rounded-5">
                                <i class="fa-solid fa-share"></i>
                                <span>Share</span>
                            </button>
                            <button class="btn btn-rounded bg-light-color has-icon rounded-circle lg">
                                <i class="fa-solid fa-link dark-color"></i>
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
                                <div class="card-body p-4 recent-file-body">
                                    <?php include "includes/bs5loader.php" ?>
                                </div>
                            </div>
                        </div>

                        <div class="all-files-container mt-3">
                            <!-- General/All Files Section -->
                            <div class="card border-0 rounded-4" style="overflow: hidden;">
                                <div class="card-header bg-white py-3 px-4">
                                    <i class="fa-solid fa-folder-open icon-normal"></i>
                                    <span class="ms-2 fw-bold">My Files</span>
                                </div>
                                <div class="card-body all-files-body p-4">
                                    <?php include "includes/bs5loader.php" ?>
                                    <!-- <div class="row row-gap-4">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="file-wrapper rounded-4 overflow-hidden shadow-sm bg-light">
                                                <div class="file-wrapper-prev d-flex flex-center">
                                                    <div class="file-wrapper-icon">
                                                        <i class="fa-solid fa-file file-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="file-wrapper-body bg-white">
                                                    <div class="d-flex ycenter justify-content-between py-2 px-3 gap-2">
                                                        <p class="file-title m-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur magni placeat quam?.</p>
                                                        <button class="btn btn-rounded bg-light-color flex-shrink-0">
                                                            <i class="fa-solid fa-ellipsis text-dark"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- file options menu -->
        <div class="menu-list position-absolute top-0 start-0 shadow-sm rounded-3 overflow-hidden bg-white d-none">
            <ul class="list-group">
                <li class="list-group-item border-0 active">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-trash icon-normal"></i>
                        <span>Delete file</span>
                    </div>
                </li>
                <li class="list-group-item border-0">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-file-pen icon-normal"></i>
                        <span>Edit file</span>
                    </div>
                </li>
                <li class="list-group-item border-0">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-share icon-normal"></i>
                        <span>Share file</span>
                    </div>
                </li>
                <li class="list-group-item border-0">
                    <div class="d-flex ycenter gap-2">
                        <i class="fa-solid fa-lock icon-normal"></i>
                        <span>Hide file</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script src="js/loader.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/file/functions.js"></script>
    <script src="js/file/file.js"></script>

</body>

</html>