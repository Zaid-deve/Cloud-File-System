$(function () {
    const searchBox = $('#file-search-inp');

    let debounceTimer,
        debounceDelay = 200;

    searchBox.on('input', function () {
        let qry = searchBox.val().trim();
        clearTimeout(debounceTimer);
        if (!qry) {
            displayFiles(__Files);
            return;
        }

        debounceTimer = setTimeout(() => {
            const files = searchFiles(__Files, qry);
            if (files && Array.isArray(files)) {
                if (files.length) {
                    displayFiles(files);
                } else {
                    $(".all-files-body").html(`<div class="p-4 text-center">
                                                    <img src="images/cute-monkey-vector-illustration_543090-186-removebg-preview.png" alt="#" height="180" class="img-contain mx-auto">
                                                    <h3 class="mt-3 text-muted">Nothing Found !</h3>
                                                    <small>Looks like theres nothing for ${qry.slice(0, 30)}...</small>
                                                    <div class="d-flex flex-center">
                                                        <a href="./" class="btn bg-prime-color px-5 rounded-5 mt-3 has-icon">
                                                            <i class="fa-solid fa-upload"></i>
                                                            <span>Upload</span>
                                                        </a>
                                                    </div>
                                                </div>`);
                }
            } else {
                displayFetchErr('Search error, failed to search files');
            }
        }, debounceDelay)
    })
})