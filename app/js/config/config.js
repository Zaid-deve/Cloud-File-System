const origin = location.origin,
    baseurl = `${origin}/cfs`,
    loc = location.href;


// files
const MaxFileUploadSize = (1024 * 1024 * 50)
let __Files = [];