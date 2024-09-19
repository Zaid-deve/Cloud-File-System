const origin = location.origin,
    baseurl = `${origin}/cfs`,
    loc = location.href

let currPage = location.pathname.split('/').pop();

// files
const MaxFileUploadSize = (1024 * 1024 * 50)
let __Files = [],
    __Checked = new Set();

// pass key info

let CURRENT_USER_PASSKEY;