// Change Text status watching
document.getElementsByClassName('btn')[0].onclick = () => {
    chageText("หอพักชาย");
    document.getElementsByClassName('plan')[0].classList.remove('deactive');
    document.getElementsByClassName('plan')[1].classList.add('deactive');
    document.getElementsByClassName('plan')[2].classList.add('deactive');
}
document.getElementsByClassName('btn')[1].onclick = () => {
    chageText("หอพักหญิง 1");
    document.getElementsByClassName('plan')[0].classList.add('deactive');
    document.getElementsByClassName('plan')[1].classList.remove('deactive');
    document.getElementsByClassName('plan')[2].classList.add('deactive');
}
document.getElementsByClassName('btn')[2].onclick = () => {
    chageText("หอพักหญิง 2");
    document.getElementsByClassName('plan')[0].classList.add('deactive');
    document.getElementsByClassName('plan')[1].classList.add('deactive');
    document.getElementsByClassName('plan')[2].classList.remove('deactive');
}

function chageText(status) {
    document.getElementById('txtStatus').innerHTML = "แผนผัง : " + status;
}
// End


// Zoom image popup close popup
var run = true;
var showImg = document.getElementById('container_ImageZoom');

document.getElementById('closeBtnImageZoom').onclick = () => {
    showImg.classList.add('deactive');
    reactiveOverflow();
}
document.getElementById('overlayImageZoom').onclick = () => {
    showImg.classList.add('deactive');
    reactiveOverflow();
}
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        showImg.classList.add('deactive');
        reactiveOverflow();
    }
};

function reactiveOverflow() {
    document.getElementById('body').style.overflow = "scroll";
}

function activeZoomPopup() {
    showImg.classList.remove('deactive');
}
// loadImage for Zoom Image
var showImage = document.getElementById("imgZoom");
window.onload = getImgName;

function getImgName(strImgPath) {
    if (run == false) {
        activeZoomPopup();
    }
    run = false;
    let strPath = "./assets/img/dorm/plan_" + strImgPath + ".webp";
    document.getElementById("imgZoom").src = strPath;
    console.log(strPath)
}

function clickZoom(group, item) {
    document.getElementById('body').style.overflow = "hidden";
    switch (group) {
        case 1:
            switch (item) {
                case 1:
                    console.log("Hit : 1, 1");
                    getImgName("male_01");
                    break;
                case 2:
                    console.log("Hit : 1, 2");
                    getImgName("male_02");
                    break;
                case 3:
                    console.log("Hit : 1, 3");
                    getImgName("male_03");
                    break;
                case 4:
                    console.log("Hit : 1, 4");
                    getImgName("male_04");
                    break;
                case 5:
                    console.log("Hit : 1, 5");
                    getImgName("male_05");
                    break;
            }
            break;
        case 2:
            switch (item) {
                case 1:
                    console.log("Hit : 2, 1");
                    getImgName("female_1_01");
                    break;
                case 2:
                    console.log("Hit : 2, 2");
                    getImgName("female_1_02");
                    break;
                case 3:
                    console.log("Hit : 2, 3");
                    getImgName("female_1_03");
                    break;
                case 4:
                    console.log("Hit : 2, 4");
                    getImgName("female_1_04");
                    break;
                case 5:
                    console.log("Hit : 2, 5");
                    getImgName("female_1_05");
                    break;
            }
            break;
        case 3:
            switch (item) {
                case 1:
                    console.log("Hit : 3, 1");
                    getImgName("female_2_01");
                    break;
                case 2:
                    console.log("Hit : 3, 2");
                    getImgName("female_2_02");
                    break;
                case 3:
                    console.log("Hit : 3, 3");
                    getImgName("female_2_03");
                    break;
                case 4:
                    console.log("Hit : 3, 4");
                    getImgName("female_2_04");
                    break;
                case 5:
                    console.log("Hit : 3, 5");
                    getImgName("female_2_05");
                    break;
            }
            break;
        default:
            console.log("non click image switch case !check");
    }

}