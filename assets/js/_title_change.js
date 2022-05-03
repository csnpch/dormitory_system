// Title
var now;
// let status = true;
var oldStr = "หอพักนักศึกษา มจพ. ปราจีนบุรี";
var newStr = "";
var title = "";

setInterval(() => {
    now = String(Math.floor(Date.now() / 1000));
}, 100)

setInterval(() => {
    now = now.substr(9);
}, 1000);

setInterval(() => {
    if (parseInt(now) % 2 == 0) {
        title = oldStr;
        document.title = title;
    } else {
        title = newStr;
        document.title = title;
    }
}, 3000);

function switchTitle(newStr) {
    this.newStr = newStr;
}