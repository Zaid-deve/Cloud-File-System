function showErr(msg = "Something Went Wrong !") {
    $('.alert-container').prepend(`<div class="alert bg-danger-color alert-dismissible fade d-flex ycenter gap-3 text-light" role="alert">
                                       <i class="fa-solid fa-circle-exclamation icon-md"></i>
                                       <div class="fw-bold">${msg}</div>
                                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-shadow: none;"></button>
                                   </div>`);

    let ref = $(".alert-container .alert").first();
    setTimeout(() => {
        if (ref.length) {
            ref.fadeOut(250, function () {
                ref.remove();
            })
        }
    }, 3000);
}