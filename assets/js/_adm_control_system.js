document.getElementsByClassName('btn_control_system_register')[0].addEventListener('click', () => {
    document.getElementsByClassName('manage_status_register')[0].classList.toggle('hidden');
});

document.getElementsByClassName('btn_control_system_main')[0].addEventListener('click', () => {
    document.getElementsByClassName('manage_status_system_main')[0].classList.toggle('hidden');
});

function toggleOverlay() {
    document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
}

function togglePopupImportantChangeImg() {
    document.getElementsByClassName('popupImportantChangeImg')[0].classList.toggle('hidden');
}

document.getElementsByClassName('btn_popupImportantChangeImg')[0].addEventListener('click', () => {
    toggleOverlay();
    togglePopupImportantChangeImg();
});

document.getElementsByClassName('btn_cancelImportantChangeImg')[0].addEventListener('click', () => {
    toggleOverlay();
    togglePopupImportantChangeImg();
})

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        toggleOverlay();
        togglePopupImportantChangeImg();
    }
};
