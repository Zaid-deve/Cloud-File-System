<?php

require_once "../config/autoload.php";
require_once "../includes/layout/head.php"

?>
<link rel="stylesheet" href="../styles/upload.css">
</head>

<body class="d-flex flex-center bg-light pt-0">

    <!-- UPLOAD CONTAINER -->
    <div class="container">
        <div class="row flex-center">
            <div class="col-md-6 col-xl-5">
                <div class="d-flex flex-center gap-3">
                    <img src="../images/brand_logo.webp" alt="#" class="img-contain" height="40">
                    <h3 class="m-0 fw-bold">Cloud Storage</h3>
                </div>
                <div class="upload-drop rounded-4 mt-3 bg-white p-4" dropzone="copy">
                    <div class="d-flex flex-center flex-column gap-2 text-center">
                        <div class="drop-img"></div>
                        <div class="mt-4">
                            <h5 class="mb-1 fw-bold">Browse Or Drop Files Heare</h5>
                            <small class="text-muted">You can select upto 75mb of each file</small>
                        </div>
                        <button class="btn bg-prime-color w-100 has-icon gap-3 rounded-3 py-3 mt-3 mb-1">
                            <i class="fa-solid fa-folder"></i>
                            <span>Browse Files</span>
                        </button>
                        <p>Need to upload large file at high speed ? <a href="#" class="text-success fw-bold">Go premium</a></p>
                    </div>
                    <input type="file" id="fileselinp" hidden>
                </div>
            </div>
        </div>
    </div>

    <!-- UPLOAD PROGRESS CONTAINER -->
    <div class="fixed-top h-100 w-100 z-1 progress-container d-none">
        <div class="container-fluid p-0">
            <div class="d-flex ycenter p-4 gap-3 bg-white">
                <i class="fa-solid fa-list-check icon-lg"></i>
                <div class="me-auto">
                    <h4 class="m-0">Upload Progress</h4>
                    <small>Track your file upload progress heare</small>
                </div>
                <div class="d-flex flex-column flex-center gap-1">
                    <button class="btn btn-cancel-all has-icon rounded-5">
                        <i class="fa-regular fa-circle-xmark icon-normal danger-color"></i>
                        <span class="danger-color">Cancel all</span>
                    </button>
                    <div class="progress-status">
                        <small class="text-muted">0 of 0 (0MB total)</small>
                    </div>
                </div>
            </div>
            <div class="row m-0 row-gap-3 py-4">
                <div class="col-md-6 col-lg-4 progress-wrapper">
                    <div class="bg-white rounded-3 p-3">
                        <div class="d-flex ycenter gap-3">
                            <div class="file-prev">
                                <i class="fa fa-solifile-titled fa-file file-icon"></i>
                            </div>
                            <div class="file-info">
                                <p class="fw-bold d-block m-0 ">Lorem ipsum dolor sit.</p>
                                <small class="text-muted fw-bold">0 MB of 75 MB</small>
                            </div>
                            <div class="ms-auto">
                                <div class="progress-status">
                                    <!-- <i class="fa-solid fa-circle-check icon-md text-success"></i> -->
                                    <!-- <i class="fa-solid fa-circle-exclamation icon-md danger-color"></i> -->
                                    <!-- <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" class="progress-svg">
                                        <circle cx="15" cy="15" r="13.5" fill="none" stroke="#E6E6E6" stroke-width="3" />
                                        <circle cx="15" cy="15" r="13.5" fill="none" stroke="#28A745" stroke-width="3" stroke-dasharray="84.78" stroke-dashoffset="21.19" stroke-linecap="round" transform="rotate(-90 15 15)" />
                                        <image href="../images/images-removebg-preview.png" x="2.5" y="2.5" width="25" height="25" />
                                    </svg> -->
                                    <small>waiting...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>