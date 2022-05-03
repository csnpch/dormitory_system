var arrayNews;

function togglePopupInsert() {
    toggleOverlay();
    document.getElementsByClassName('popupInsert')[0].classList.toggle('hidden');
}

function setValueNews(array) {
    arrayNews = array
}

function togglePopupEdit(idNews) {
    document.getElementsByClassName('popupEdit')[0].classList.toggle('hidden');
    toggleOverlay();
    showDataForEdit(idNews);
}

function showDataForEdit(idNews) {
    toggleOverlay();
    for (let i = 0; i < arrayNews.length; i++) {
        if (arrayNews[i][0] == idNews) {
            document.forms['form_editDataNews']['txt_news_id_edit'].value = arrayNews[i][0];
            document.forms['form_editDataNews']['txt_news_title_edit'].value = arrayNews[i][1];
            document.forms['form_editDataNews']['txt_news_img_edit'].value = arrayNews[i][2];
            document.forms['form_editDataNews']['txt_news_link_edit'].value = arrayNews[i][3];
        }    
    }
}

function toggleOverlay() {
    document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
}

function togglePopupImportantChangeImgNews() {
    document.getElementsByClassName('popupImportantChangeImgNews')[0].classList.toggle('hidden');
}

document.getElementsByClassName('btn_popupImportantChangeImgNews')[0].addEventListener('click', () => {
    toggleOverlay();
    togglePopupImportantChangeImgNews();
});

document.getElementsByClassName('btn_cancelImportantChangeImgNews')[0].addEventListener('click', () => {
    toggleOverlay();
    togglePopupImportantChangeImgNews();
})

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        toggleOverlay();
        document.getElementsByClassName('popupInsert')[0].classList.add('hidden');
        document.getElementsByClassName('popupEdit')[0].classList.add('hidden');
        document.getElementsByClassName('overlayEdit')[0].classList.add('hidden');
    }
};

document.getElementsByClassName('btn_cancelInsert')[0].addEventListener('click', () => { togglePopupInsert(); })
document.getElementsByClassName('btn_addNews')[0].addEventListener('click', () => { togglePopupInsert(); })
document.getElementsByClassName('btn_cancelEdit')[0].addEventListener('click', () => { togglePopupEdit(); })

// for (let i = 0; i < document.getElementsByClassName('btn_delete_news_check').length; i++) {
//     document.getElementsByClassName('btn_delete_news_check')[i].addEventListener('click', () => {
//         Swal.fire({
//             title: 'คุณต้องการที่จะลบข่าวใช่หรือไม่',
//             text: 'หากลบแล้วจะไม่สามารถกู้คืนข้อมูลกลับมาได้',
//             icon: 'warning',
//             showConfirmButton: true,
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'ยืนยัน',
//             cancelButtonText: 'ยกเลิก'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 document.getElementsByClassName('btn_delete_news')[i].click();
//             }
//         })
//     });
// }