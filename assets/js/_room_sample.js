// Check event on click button
var txtStatus = document.getElementsByClassName('statusTxt')[0];
document.getElementsByClassName('btn')[0].onclick = () => {
    chageStatus("หอพักชาย");
    document.getElementsByClassName('textDescript')[0].classList.remove('deactive');
    document.getElementsByClassName('textDescript')[1].classList.add('deactive');
    document.getElementsByClassName('textDescript')[2].classList.add('deactive');
    document.getElementsByClassName('dorm')[0].classList.remove('deactive');
    document.getElementsByClassName('dorm')[1].classList.add('deactive');
    document.getElementsByClassName('dorm')[2].classList.add('deactive');
}
document.getElementsByClassName('btn')[1].onclick = () => {
    chageStatus("หอพักหญิง 1");
    document.getElementsByClassName('textDescript')[0].classList.add('deactive');
    document.getElementsByClassName('textDescript')[1].classList.remove('deactive');
    document.getElementsByClassName('textDescript')[2].classList.add('deactive');
    document.getElementsByClassName('dorm')[0].classList.add('deactive');
    document.getElementsByClassName('dorm')[1].classList.remove('deactive');
    document.getElementsByClassName('dorm')[2].classList.add('deactive');
}
document.getElementsByClassName('btn')[2].onclick = () => {
    chageStatus("หอพักหญิง 2");
    document.getElementsByClassName('textDescript')[0].classList.add('deactive');
    document.getElementsByClassName('textDescript')[1].classList.add('deactive');
    document.getElementsByClassName('textDescript')[2].classList.remove('deactive');
    document.getElementsByClassName('dorm')[0].classList.add('deactive');
    document.getElementsByClassName('dorm')[1].classList.add('deactive');
    document.getElementsByClassName('dorm')[2].classList.remove('deactive');
}

function chageStatus(status) {
    txtStatus.innerHTML = status;
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
    let strPath = "./assets/img/dorm/room_" + strImgPath + ".webp";
    document.getElementById("imgZoom").src = strPath;
    // console.log(strPath)
}

function reactiveOverflow() {
    document.getElementById('body').style.overflow = "scroll";
}

function clickZoom(group, item) {
    document.getElementById('body').style.overflow = "hidden";
    switch (group) {
        case 1:
            switch (item) {
                case 1:
                    getImgName("male_01");
                    break;
                case 2:
                    getImgName("male_02");
                    break;
                case 3:
                    getImgName("male_03");
                    break;
                case 4:
                    getImgName("male_04");
                    break;
                case 5:
                    getImgName("male_05");
                    break;
                case 6:
                    getImgName("male_06");
                    break;
                case 7:
                    getImgName("male_07");
                    break;
                case 8:
                    getImgName("male_08");
                    break;
                case 9:
                    getImgName("male_09");
                    break;
                    // 10
            }
            break;
        case 2:
            switch (item) {
                case 1:
                    getImgName("female_1_01");
                    break;
                case 2:
                    getImgName("female_1_02");
                    break;
                case 3:
                    getImgName("female_1_03");
                    break;
                case 4:
                    getImgName("female_1_04");
                    // 5, 6, 7, 8, 9, 10
            }
            break;
        case 3:
            switch (item) {
                case 1:
                    getImgName("female_2_01");
                    break;
                case 2:
                    getImgName("female_2_02");
                    break;
                case 3:
                    getImgName("female_2_03");
                    break;
                case 4:
                    getImgName("female_2_04");
                    break;
                case 5:
                    getImgName("female_2_05");
                    break;
                    // 6, 7, 8, 9, 10
            }
            break;
    }
}