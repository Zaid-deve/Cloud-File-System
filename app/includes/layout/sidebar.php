<aside class="sidebar p-3 p-sm-4 hide">
    <div>
        <div onclick="location.href = '/cfs/app/user/account.php'" class="account-block bg-light-color py-2 px-3 rounded-4">
            <div class="d-flex ycenter gap-2">
                <div class="profile-img">
                    <img src="<?php echo $user_profile ?? "$baseurl/app/images/default.png" ?>" alt="#" class="img-cover rounded-circle" height="40">
                </div>
                <div class="profile-info">
                    <strong class="d-block"><?php echo $user_name ?? 'add name' ?></strong>
                    <small class="text-muted">---</small>
                </div>
                <div class="ms-auto">
                    <a href="/cfs/app/user/logout.php" class="btn pe-0">
                        <i class="fa-solid fa-power-off icon-md text-dark"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-list mt-3">
        <ul class="list-group">
            <li class="list-group-item border-0 p-0 active">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-house"></i>
                    <span class="fw-bold">Home</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-table-cells-row-unlock"></i>
                    <span class="fw-bold">Hidden Space</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span class="fw-bold">Settings</span>
                </a>
            </li>

            <li class="list-group-item border-0 p-0">
                <a href="#" class="d-flex y-center gap-2 p-3 text-muted">
                    <i class="fa-solid fa-headset"></i>
                    <span class="fw-bold">Customer Support</span>
                </a>
            </li>
        </ul>
    </div>
</aside>