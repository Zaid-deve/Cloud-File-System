<div class="popup-container fixed-top bg-light-60 vh-100 vw-100 d-none" style="z-index: 1052;">
    <div class="container h-100">
        <div class="row m-0 g-0 h-100 flex-center">
            <div class="col-md-8 col-lg-6 col-xl-5 popup-box d-none">
                <div class="card border-0 popup popup-update-profile bg-white rounded-4 overflow-hidden shadow">
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

            <div class="col-md-8 col-lg-6 col-xl-5 popup-box d-none">
                <div class="card border-0 popup popup-delete bg-white rounded-4 overflow-hidden shadow">
                    <div class="card-header py-3 px-4 bg-white">
                        <h3 class="m-0">Delete File</h3>
                        <small>Are you sure you want to delete this item?</small>
                    </div>
                    <div class="card-body fw-bold px-4 py-3">
                        <div class="delete-ins">
                            <p>2 files selected</p>
                            <p>total size of files 250 kb</p>
                            <p class="text-danger">This Action cannot be undone, <br> please delete on your own risk</p>
                        </div>

                        <div class="d-flex flex-center gap-3 mt-4">
                            <button class="btn btn-danger has-icon w-50 gap-3 rounded-5 btn-confirm-delete">
                                <i class="fa-solid fa-trash"></i>
                                <span class="fw-bold">Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-6 col-xl-5 popup-box d-none">
                <div class="card border-0 popup popup-edit bg-white rounded-4 overflow-hidden shadow">
                    <div class="card-header py-3 px-4 bg-white">
                        <h3 class="m-0">Edit File</h3>
                        <small>Update file details and permissions</small>
                    </div>
                    <div class="card-body px-4 py-3">

                        <!-- Edit file name -->
                        <div class="mt-3">
                            <label for="filename" class="fw-bold">File Name:</label>
                            <input type="text" id="edit-filename" placeholder="Enter file name" class="form-control mt-2 mb-1 lg">
                            <small class="danger-color"></small>
                        </div>

                        <!-- File permissions -->
                        <div class="mt-4">
                            <label class="fw-bold">Permissions:</label>
                            <div class="mt-2">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="checkbox" id="view-permission" class="form-check-input">
                                    <label for="view-permission" class="form-check-label">Allow View</label>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <input type="checkbox" id="edit-permission" class="form-check-input">
                                    <label for="edit-permission" class="form-check-label">Allow Edit</label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button class="btn bg-prime-color has-icon px-4 w-50 gap-3 rounded-5">
                                <span class="fw-bold">Update</span>
                                <i class="fa-solid fa-file-pen"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>


            <!-- hide file popup -->
            <div class="col-md-8 col-lg-6 col-xl-5 popup-box d-none">
                <div class="card border-0 popup popup-set-passkey bg-white rounded-4 overflow-hidden shadow">
                    <div class="card-header py-3 px-4 bg-white">
                        <h3 class="m-0">Setup Secure Passkey</h3>
                        <small>Please create a strong passkey to hide and access you private files</small>
                    </div>
                    <div class="card-body px-4 py-3">
                        <!-- Edit file name -->
                        <div class="mt-3">
                            <label for="filename" class="fw-bold">Passkey (6 - 24 length)</label>
                            <input type="text" id="passkey-inp" placeholder="Enter pass key" class="form-control mt-2 mb-1 lg">
                            <small class="danger-color"></small>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button class="btn bg-prime-color has-icon px-4 w-50 gap-3 rounded-5" disabled>
                                <i class="fa-solid fa-lock"></i>
                                <span class="fw-bold">Set passkey</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>