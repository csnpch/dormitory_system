document.getElementById('container_navbar').classList.add('deactive');
setTimeout(() => { 
    document.getElementById('indexPage').classList.remove('deactive');
    document.getElementById('container_navbar').classList.remove('deactive');
}, 1000);
setTimeout(() => { document.getElementById('logoLoading').classList.add('-top-full'); }, 2000);
setTimeout(() => {
    document.getElementsByClassName('overflow-hidden')[0].classList.remove('overflow-hidden');
    document.getElementById('logoLoading').style.display = 'none';
}, 2800);

let indexImageSlide = 0;
let images = [];
images[0] = "url('./assets/img/dorm/women_01.webp')";
images[1] = "url('./assets/img/dorm/women_02.webp')";

function changeImg() {
    let bannerChageImage = document.getElementById("slide");
    bannerChageImage.style.background = images[indexImageSlide];
    bannerChageImage.style.backgroundAttachment = "fixed";
    (indexImageSlide < images.length - 1) ? indexImageSlide++ : indexImageSlide = 0;
    setTimeout("changeImg()", 4000);
}
window.onload = changeImg;
// End


// Close popup
var popup = document.getElementById('container_popup');
document.getElementById('closeBtn').onclick = () => {
    popup.classList.add('deactive');
    checkStatusBook();
}

document.getElementById('overlayPopup').onclick = () => {
    popup.classList.add('deactive');
    checkStatusBook();
}


// Close popup news
var popupNews = document.getElementById('container_popupNews');
// var popupNews = document.getElementsByClassName('container_popupNews')[0];

document.getElementById('popupNews').onclick = () => {
    popupNews.classList.remove('deactive');
}

document.getElementById('closeBtnNews').onclick = () => {
    popupNews.classList.add('deactive');
}

document.getElementById('overlayPopupNews').onclick = () => {
    popupNews.classList.add('deactive');
}


document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        popup.classList.add('deactive');
        popupNews.classList.add('deactive');
    }
};

// Hidden arrow down on banner
window.addEventListener('scroll', function() {
    let checkScroll = window.scrollY;
    if (checkScroll > 100) {
        checkScroll.scrollY(1000, 1000);
        document.getElementById("godown").classList.add('deactive');
    } else {
        document.getElementById("godown").classList.remove('deactive');
    }
})
