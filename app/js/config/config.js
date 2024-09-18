const origin = location.origin,
    baseurl = `${origin}/cfs`,
    loc = location.href


let currPage = loc.split('/').pop() ?? 'index.php';

currPage = currPage.slice(0, currPage.lastIndexOf('?'));

// files
const MaxFileUploadSize = (1024 * 1024 * 50)
let __Files = [],
    __Checked = new Set();