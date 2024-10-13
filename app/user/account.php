<?php


require_once "../config/autoload.php";
require_once "../php/b2/b2file.php";

$b2 = new B2File();
$stmt = $db->qry("SELECT file_name name, file_id id,file_size size, file_type type, file_perms perms,file_timestamp upload_time, file_last_viewed recent, file_visibility visibility,x_bz_name FROM file_uploads WHERE file_uploader_id = ? AND file_timestamp >= NOW() - INTERVAL 1 DAY  LIMIT 4", ["{$authType}_{$uid}"]);
if ($stmt === false) {
    $stmt = [];
}

$stmt = array_map(function ($s) use ($b2) {
    $s['downloadUrl'] = $b2->getDownloadUrl($s['x_bz_name']);
    return $s;
}, $stmt);

echo "<script>const data = " . json_encode($stmt) . "</script>";

require_once "../includes/layout/head.php";
?>

<link rel="stylesheet" href="../styles/layout/header.css">
<link rel="stylesheet" href="../styles/index.css">
<link rel="stylesheet" href="../styles/file.css">

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
        <div class="card mb-4 border-0 rounded-4 py-2 px-3">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap row-gap-4">
                    <img src="<?php echo $user_profile ?>" alt="ProfileImg" class="rounded-circle me-3 is-profile userprofile bg-light-color" width="40%" style="max-width: 65px">
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold username w-50"><?php echo $user_name ?></h5>
                        <p class="mb-0 secondary-color useremail w-50"><?php echo $user_email ?></p>
                    </div>
                    <div class="d-flex flex-center ms-auto gap-3">
                        <button class="btn bg-light-color rounded-5 has-icon btn-edit-profile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                            <span>Edit Profile</span>
                        </button>
                        <a class="btn bg-light-color rounded-5 has-icon" href="logout.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-box-arrow-in-right danger-color" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
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
                <div class="row row-gap-3 recent-files-row">
                    <?php require_once "../includes/bs5loader.php"; ?>
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