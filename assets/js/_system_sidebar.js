function checkWidth() {
    width = document.body.clientWidth;
    if (width < 1024) return 1;
    else return 0;
}

function sidebarResponsive() {
    document.getElementById('overlay').classList.add('deactive');
    document.getElementById('sidebar').classList.add('-ml-80');
    document.getElementById('container').classList.add('lg:ml-64');
    document.getElementById('title_nav').classList.add('md:-ml-32');
}

// Sticky navbar
window.addEventListener('scroll', function() {
    let checkScroll = window.scrollY;
    if (checkScroll > 0) {
        document.getElementById("navbar").classList.remove('h-14');
        document.getElementById("navbar").classList.add('h-9');
        document.getElementById('logo').classList.remove('line_b_white_5');
        document.getElementById('user').classList.remove('mt-8');
        document.getElementById('user').classList.add('mt-6');
    }  else {
        document.getElementById('user').classList.remove('mt-6');
        document.getElementById('user').classList.add('mt-8');
        document.getElementById("navbar").classList.add('h-14');
        document.getElementById('logo').classList.add('line_b_white_5');
    }
})

document.getElementById('menu').onclick = () => {
    if(checkWidth() == 0) {
        document.getElementById('sidebar').classList.toggle('lg:ml-0');
        document.getElementById('container').classList.toggle('lg:ml-64');
    } else {
        document.getElementById('overlay').classList.toggle('deactive');
        document.getElementById('sidebar').classList.toggle('-ml-80');
        document.getElementById('container').classList.toggle('lg:ml-64');
    }
}


document.getElementById('overlay').onclick = () => {
    sidebarResponsive();
}

document.getElementById('close_sidebar').onclick = () => {
    sidebarResponsive();
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        sidebarResponsive();
    }
};
