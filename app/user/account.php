<?php


require_once "../config/autoload.php";
require_once "../includes/layout/head.php";
?>

<body class="bg-light">

    <!-- BODY -->

    <?php

    require_once "../includes/layout/header.php";
    require_once "../includes/alert.php";
    require_once "../includes/notify.php";
    require_once "../includes/popup.php";

    ?>

    <div class="container py-4">
        <!-- User Info Card -->
        <div class="card mb-4 border-0 rounded-5 py-3 p-4">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap row-gap-4">
                    <img src="<?php echo $user_profile ?>" alt="ProfileImg" class="rounded-circle me-3 is-profile userprofile" width="40%"  style="max-width: 65px">
                    <div>
                        <h5 class="mb-1 fw-bold useranme"><?php echo $user_name ?></h5>
                        <p class="mb-0 fw-bold prime-color useremail"><?php echo $user_email ?></p>
                    </div>
                    <div class="d-flex flex-center ms-auto">
                        <button class="btn has-icon ms-auto text-decoration-underline btn-edit-profile">
                            <i class="fa-solid fa-user-pen dark-color"></i>
                            <span class="dark-color">Edit Profile</span>
                        </button>
                        <a class="btn has-icon" href="logout.php">
                            <i class="fa-solid fa-power-off icon-md danger-color"></i>
                            <span class="danger-color">Sign out</span>
                        </a>
                    </div>
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


    <!-- SCRIPTS -->
    <script src="../js/config/config.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/img.js"></script>
    <script src="../js/file/functions.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/user/account.js"></script>

</body>

</html>