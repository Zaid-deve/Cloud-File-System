<header class="navbar navbar-expand-lg py-4 fixed-top w-100 bg-white page-header">
    <div class="container-fluid">
        <?php if (isset($showNavToggle)) { ?>
            <button class="btn btn-toggle-sidebar bg-light-color p-2" onclick="$('.sidebar-wrapper').toggleClass('hide')">
                <span></span>
                <span></span>
                <span></span>
            </button>
        <?php } ?>

        <a class="navbar-brand d-flex gap-3 row-gap-0 ms-2 me-auto" href="/cfs/app">
            <img src="<?php echo "$baseurl/app/images/brand_logo.webp" ?>" alt="Logo" class="img-contain page-logo">
            <div class="fw-bolder logo-text">Cloud <br class="d-block d-sm-none"> Storage</div>
        </a>

        <button class="btn bg-light-color rounded-5 has-icon btn-show-download-popup">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download icon-svg dark-color" viewBox="0 0 16 16">
                <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
            </svg>
            <span class="dark-color fw-normal d-md-block d-none">Downloads</span>
        </button>

        <div class="nav-right ms-2">
            <?php if (empty($uid)) { ?>
                <a class="btn bg-dark has-icon rounded-5" href="<?php echo "$baseurl/app/user/auth/signin.php" ?>">
                    <i class="fa-solid fa-user-lock icon-normal"></i>
                    <span class="fw-bold d-md-block d-none">Login</span>
                </a>
            <?php } else { ?>
                <a class="btn bg-dark has-icon rounded-5" href="<?php echo "$baseurl/app/upload/upload.php" ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill icon-svg" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    <span class="fw-bold d-md-block d-none">Upload Files</span>
                </a>
            <?php } ?>
        </div>
    </div>
</header>