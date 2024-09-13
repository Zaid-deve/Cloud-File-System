$(function(){
    $(".popup-container").click(function(e){
        let t = $(e.target).closest('.popup');
        if(!t.length){
            hidePopup();
        }
    })

    $('#profileimg').change(e => {
        const file = e.target.files[0]
        if(file){
            if(!isImg(file)){
                showErr('Profile image should be an valid image');
                return;
            }

            if(file.size > (1024 * 1024 * 2)){
                showErr('Profile image should be of maximum 2 mb');
                return;
            }

            const blob = URL.createObjectURL(file);
            $('#edit-prev-img').prop('src', blob);
        }
    })

    $(".btn-update-profile").click(function(){
        showErr('Service unavailable at a movement');
    })
});