<?php

require_once "../config/autoload.php";
require_once "../includes/layout/head.php"

?>
<link rel="stylesheet" href="../styles/upload.css">
</head>

<body class="d-flex flex-center bg-light pt-0 my-3">

    <!-- BODY -->

    <?php

    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";

    ?>

    <!-- UPLOAD CONTAINER -->
    <div class="container">
        <div class="row flex-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
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
                        <button class="btn bg-prime-color w-100 has-icon gap-3 rounded-3 py-3 mt-3 mb-1 btn-browse-files">
                            <i class="fa-solid fa-folder"></i>
                            <span>Browse Files</span>
                        </button>
                        <p>Need to upload large file at high speed ? <a href="#" class="text-success fw-bold">Go premium</a></p>
                    </div>
                    <input type="file" id="fileselinp" multiple hidden>
                </div>
            </div>
        </div>
    </div>

    <!-- UPLOAD PROGRESS CONTAINER -->
    <div class="fixed-top h-100 w-100 z-1 progress-container d-none bg-white">
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
                    <div class="d-flex flex-center gap-2">
                        <div class="total-progress-files">0 of 0</div>
                        <div class="total-progress-bytes">(0 of 0)</div>
                    </div>
                </div>
            </div>
            <div class="row m-0 row-gap-3 py-4 progress-row"></div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="../js/config/config.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/img.js"></script>
    <script src="../js/file/functions.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/file/upload.js"></script>

</body>

</html>