function get_select_option_book(status) {
    switch (status) { 
        case 0: 
            window.location = 'book_zone_manage.php?' + 'building=' + document.getElementById('select_building').value;
            break
        case 1:
            window.location = 'book_zone_manage.php?' + 'building=' + document.getElementById('select_building').value + '&floor=' + document.getElementById('select_floor').value;
            break
    }
}


function checkBoxAll() {
    for (let i = 0; i < document.getElementsByClassName('checkbox_room').length; i++) {
        document.getElementsByClassName('checkbox_room')[i].checked = (document.getElementById('checkbox_all').checked == true ? true : false);
    }
}
