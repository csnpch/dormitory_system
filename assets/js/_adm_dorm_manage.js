function togglePopupSelectChoice() {
    setTimeout(() => {
        document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
        document.getElementById('add_item').classList.toggle('hidden');
        document.forms["frm_add_building"]["txt_building_name"].focus();
    }, 200);
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        togglePopupSelectChoice();
    }
};

document.getElementById('btn_manage').addEventListener('click', () => {
    togglePopupSelectChoice();
})

document.getElementsByClassName('overlay')[0].addEventListener('click', () => {
    togglePopupSelectChoice();
})

document.getElementsByClassName('cancleInsertDorm')[0].addEventListener('click', () => {
    togglePopupSelectChoice();
})