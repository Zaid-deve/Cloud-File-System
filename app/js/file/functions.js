function isImg(file) {
    const imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    return file && imageTypes.includes(file.type);
}

function generateUniqueFileId(file) {
    const rdig = Math.floor(Math.random() * 1000),
        fileName = file.name.replace(/\s+/g, '');

    return `${fileName}_${file.size}_${Date.now()}_${rdig}`;
}

// upload functions

function getUploadHandler(file){
    if(file){
        return null;
    }
}