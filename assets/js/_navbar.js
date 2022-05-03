// Sticky navbar
window.addEventListener('scroll', function() {
    let checkScroll = window.scrollY;
    if (checkScroll > 0) {
        document.getElementById("container_navbar").classList.add('navSticky');
    } else {
        document.getElementById("container_navbar").classList.remove('navSticky');
    }
})
// End

function activeSubMenuResponsive() {
    document.getElementById('sub-menu-respons').classList.toggle('deactive');
}

// Navigation responsive and action user
document.querySelector('.sub-MenuMain').onclick = () => {
    document.querySelector('.verSubMenuMain').classList.toggle("activeFlex");
}

document.querySelector('.menu-btn').onclick = () => {
    document.querySelector('body').classList.add("deScroll");
    document.querySelector('.side-bar').classList.toggle("activeSidebar");
    document.querySelector('.overlay').classList.toggle("activeOverlay");
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        detorySidebar();
    }
};

document.querySelector('.overlay').onclick = () => {
    detorySidebar();
}

document.querySelector('.close-btn-sidebar').onclick = () => {
    detorySidebar();
}

function detorySidebar() {
    document.querySelector('body').classList.remove("deScroll");
    document.querySelector('.side-bar').classList.remove("activeSidebar");
    document.querySelector('.overlay').classList.remove("activeOverlay");
}

document.querySelector('.sub-btn').onclick = () => {
    document.querySelector('.sub-btn i').classList.toggle('rotate');
}


function openSubmenu(status) {
    switch(status) {
        case 0:
            document.querySelector('.verSubMenuMain').classList.toggle("activeFlex");
            break;
        case 1:
            document.querySelector('.verSubMenuMain').classList.add("activeFlex");
            break;
        case 2:
            document.querySelector('.verSubMenuMain').classList.remove("activeFlex");
            break;
    }
}

// Dropdown sidebar
// $(document).ready(function() {
//     $('.sub-btn').click(function() {
//         $(this).next('.sub-menu').slideToggle();
//     });
// });
// End

// Login check
// userLogin normal
// function userLogin() {
//     document.getElementsByClassName('destroyUserLogin')[0].classList.add('deactive');
//     document.getElementsByClassName('destroyUserLogin')[1].classList.add('deactive');
//     document.getElementsByClassName('userLogin')[0].classList.remove('deactive');
//     document.getElementsByClassName('userLogin')[1].classList.remove('deactive');
//     document.getElementsByClassName('btnLogout')[0].classList.remove('deactive');
// }
// Admin Login
// function adminLogin() {
//     document.getElementsByClassName('destroyAdminLogin')[0].classList.add('deactive');
//     document.getElementsByClassName('destroyAdminLogin')[1].classList.add('deactive');
//     document.getElementsByClassName('adminLogin')[0].classList.remove('deactive');
//     document.getElementsByClassName('adminLogin')[1].classList.remove('deactive');
//     document.getElementsByClassName('btnLogout')[0].classList.remove('deactive');
// }
// End

