<header class="navbar navbar-expand-lg py-4 fixed-top w-100 bg-white">
    <div class="container-fluid">
        <?php if (isset($showNavToggle)) { ?>
            <button class="btn btn-toggle-sidebar bg-light-color p-2" onclick="$('.sidebar-wrapper').toggleClass('hide')">
                <span></span>
                <span></span>
                <span></span>
            </button>
        <?php } ?>

        <a class="navbar-brand d-flex flex-center gap-3 ms-3" href="/cfs/app">
            <img src="<?php echo "$baseurl/app/images/brand_logo.webp" ?>" alt="Logo" class="img-contain" height="40">
            <div class="fw-bolder logo-text">Cloud <br class="d-block d-sm-none"> Storage</div>
        </a>

        <div class="nav-right ms-auto">
            <?php if (empty($uid)) { ?>
                <a class="btn bg-dark has-icon px-md-5 rounded-5" href="<?php echo "$baseurl/app/user/auth/signin.php" ?>">
                    <i class="fa-solid fa-user-lock icon-normal"></i>
                    <span class="fw-bold">Login</span>
                </a>
            <?php } else { ?>
                <a class="btn bg-prime-color has-icon px-md-5 rounded-5" href="<?php echo "$baseurl/app/upload/upload.php" ?>">
                    <i class="fa-solid fa-upload fs-6"></i>
                    <span class="fw-bold fs-6">Upload</span>
                </a>
            <?php } ?>
        </div>
    </div>
</header>