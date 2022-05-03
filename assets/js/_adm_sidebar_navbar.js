// Sticky navbar
window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        document.getElementsByClassName("menu_scroll")[0].classList.remove('hidden');
    } else {
        document.getElementsByClassName("menu_scroll")[0].classList.add('hidden');
    }
})
// End

function activeSidebar() {
    if (document.body.clientWidth > 1000) {
        document.getElementById('sidebar').classList.toggle('lg:ml-0');
        ['lg:ml-64', 'lg:w-11/12'].forEach(
            e => document.getElementById('main').classList.toggle(e)
        );
        document.getElementById('closeSidebar').classList.add('hidden');
    } else {
        document.getElementById('overlay').classList.toggle('deactive');
        document.getElementById('sidebar').classList.add('w-64');
        document.getElementById('sidebar').classList.remove('-ml-64');
        document.getElementById('closeSidebar').classList.remove('hidden');
    }
}

function slideSidebar() {
    document.getElementById('overlay').classList.add('deactive');
    document.getElementById('sidebar').classList.add('-ml-64');
}

if (window.location.pathname.split('.php')[0].split('/')[window.location.pathname.split('.php').length+1] == 'dashboard') {
    document.getElementsByClassName('watchMyWeb')[0].classList.remove('deactive');
} else if (window.location.pathname.split('.php')[0].split('/')[window.location.pathname.split('.php').length+1] == 'news_manage') {
    document.getElementsByClassName('websiteDetailManagerButton')[0].classList.remove('deactive');
    document.getElementsByClassName('websiteDetailManagerButton')[1].classList.add('deactive');
}



// window.addEventListener("resize", () => {
//     var width = document.body.clientWidth;
//     if (width < 1000) {

//     }
// });
