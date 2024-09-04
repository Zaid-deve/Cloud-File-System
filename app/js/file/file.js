$(async function () {


    // fetch files from server
    const target_id = null,
        files = [];


    // dom

    let allFilesBody = $(".all-files-body"),
        recentFilesContainer = $(".recent-files-container"),
        recentFilesBody = $(".recent-file-body")


    try {

        // call files api {static}
        let data = null;
        // let data = await getFiles(target_id);

        if (!data) {
            recentFilesContainer.hide();
            allFilesBody.html(`<div class="p-4 text-center">
                                   <img src="images/nofiles (2).png" alt="#" height="180" class="img-contain mx-auto">
                                   <h3 class="mt-3">No Files Yet !</h3>
                                   <small>It looks like you dont have files to show heare, <br> start uploading files end-to-end encrypted</small>
                                   <div class="d-flex flex-center">
                                       <a href="upload/upload.php" class="btn bg-prime-color px-4 rounded-5 mt-3 has-icon">
                                           <i class="fa-solid fa-upload"></i>
                                           <span>Upload Files</span>
                                       </a>
                                   </div>
                               </div>`);
        }

    } catch (e) {

    }

})