<aside class="sidebar bg-white rounded-4 h-100 overflow-hidden">
    <div>
        <div onclick="location.href = '/cfs/app/user/account.php'" class="account-block pt-3 px-4">
            <div class="d-flex ycenter gap-2">
                <div class="profile-img">
                    <img src="<?php echo $user_profile ?? "$baseurl/app/images/default.png" ?>" alt="#" class="img-cover rounded-circle is-profile" height="40">
                </div>
                <div class="profile-info">
                    <strong class="d-block"><?php echo $user_name ?? 'add name' ?></strong>
                    <small class="text-muted"><?php echo $user_join_date ?? '---' ?></small>
                </div>
                <div class="ms-auto">
                    <a href="/cfs/app/user/logout.php" class="btn pe-0">
                        <i class="fa-solid fa-person-walking-arrow-right icon-md text-dark"></i>
                        <!-- <i class="fa-solid fa-power-off "></i> -->
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4">
        <hr>
    </div>

    <div class="sidebar-list p-3 pt-0">
        <ul class="list-group">
            <li class="list-group-item border-0 p-0 active">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-house-crack"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-file-shield"></i>
                    <span>Hidden Space</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-gears"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-headset"></i>
                    <span>Customer Support</span>
                </a>
            </li>
        </ul>
    </div>
</aside>