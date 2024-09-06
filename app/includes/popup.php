<div class="popup-container fixed-top bg-light-60 vh-100 vw-100 d-none" style="z-index: 1052;">
    <div class="container h-100">
        <div class="row m-0 g-0 h-100 flex-center">
            <div class="col-md-8 col-lg-6 col-xl-5 popup-box">
                <div class="card border-0 popup popup-update-profile bg-white rounded-4 overflow-hidden shadow d-none">
                    <div class="card-header py-3 px-4 bg-white">
                        <h3 class="m-0">Update Profile</h3>
                        <small>update profile and details</small>
                    </div>
                    <div class="card-body px-4 py-3">
                        <div>
                            <div class="d-flex flex-center flex-column gap-2">
                                <img src="/cfs/app/images/default.png" alt="#" width="75" class="rounded-circle bg-light" id="edit-prev-img">
                                <div class="secondary-color">
                                    <label for="profileimg">
                                        <span class=" text-decoration-underline fw-bold">Update profile</span>
                                    </label>
                                </div>
                            </div>
                            <input type="file" id="profileimg" hidden accept="image/*">
                        </div>
                        <div class="mt-3">
                            <label for="username">Username:</label>
                            <input type="text" id="edit-username" placeholder="Enter user name" class="form-control mt-2 mb-1 lg">
                            <small class="danger-color"></small>
                        </div>
                        <div class="mt-3">
                            <label>Email Address:</label>
                            <input type="text" disabled class="form-control mt-2 mb-1 lg" value="patelzaid721@gmail.com" id="edit-email">
                        </div>
                        <button class="btn bg-prime-color has-icon py-3 w-100 gap-3 mt-4 rounded-4 btn-update-profile">
                            <span>Continue</span>
                            <i class="fa-solid fa-right-long"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>