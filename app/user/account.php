<?php


require_once "../config/autoload.php";
require_once "../includes/layout/head.php";
?>

<body class="bg-light">

    <!-- BODY -->

    <!-- COMPS -->
    <?php

    require_once "../includes/layout/header.php";
    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";

    ?>

    <div class="container my-5">
        <!-- User Info Card -->
        <div class="card mb-4 border-0 rounded-5 py-3 p-4">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap">
                    <img src="../images/default.png" alt="ProfileImg" class="rounded-circle me-3" width="50">
                    <div>
                        <h5 class="mb-1 fw-bold">John Doe</h5>
                        <p class="mb-0 fw-bold prime-color">johndoe@example.com</p>
                    </div>
                    <button class="btn has-icon ms-auto">
                        <i class="fa-solid fa-user-pen prime-color"></i>
                        <span class="prime-color">Edit Profile</span>
                    </button>
                    <a href="logout.php" class="ms-2">
                        <i class="fa-solid fa-power-off icon-md prime-color"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Files Section -->
        <div class="card border-0 rounded-4" style="overflow: hidden;">
            <div class="card-header bg-white py-3 px-4">
                <i class="fa-solid fa-clock-rotate-left icon-normal"></i>
                <span class="ms-2 fw-bold">My Recent Files</span>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- File 1 -->
                    <!-- <div class="col-md-4">
                        <div class="card bg-light-color border-0 h-100">
                            <div class="card-body text-center">
                                <div class="p-3 mx-auto">
                                    <i class="fa-solid fa-file-pdf fs-1"></i>
                                </div>
                                <h6 class="fw-bold mb-1">document.pdf</h6>
                                <small class="text-muted">2 Days ago...</small>
                            </div>
                        </div>
                    </div> -->

                    <!-- No recents -->
                    <div class="p-4 text-center">
                        <h3>No Recent Files</h3>
                        <small>Uploaded files within 24hrs will show heare...</small>
                        <div class="d-flex flex-center">
                            <a href="../upload/upload.php" class="btn bg-prime-color py-3 px-5 rounded-5 mt-3 has-icon">
                                <i class="fa-solid fa-upload"></i>
                                <span>Upload Files</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>