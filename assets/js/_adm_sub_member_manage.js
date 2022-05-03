function setDataFacBranchStd(dataFacBranch) {
    console.log(dataFacBranch);
    try {
        document.getElementById('select_branch').value = dataFacBranch.branch_id;   
        document.getElementById('select_faculty').value = dataFacBranch.fac_id;
    } catch (error) { }
}

function setDataFacBranchStdEmpty() {
    document.getElementById('select_branch').value = 'null';   
    document.getElementById('select_faculty').value = 'null';
}

function sure_toDestroyBook() {
    Swal.fire({
        title: 'คุณต้องการยกเลิกห้องพัก ?',
        text: 'ต้องการยกลิกห้องพักของนักศึกษาใช่หรือไม่ !!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันการแก้ไขข้อมูล',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('btn_cancleBook').click();
        }
    })
}

function updateData(idWhere) {
    Swal.fire({
        title: 'คุณต้องการแก้ไขข้อมูลใช่หรือไม่',
        text: 'โปรดตรวจสอบข้อมูลให้ถูกต้องก่อนทำการบันทึกข้อมูล',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันการแก้ไขข้อมูล',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(idWhere).click();
        }
    })
}


window.onload = () => {
    let pathHash, page;
    pathHash = window.location.href;
    pathHash = pathHash.split("?")[1].split("&");
    if (pathHash[0] == 'dataStd') page = 0;
    else if (pathHash[0] == 'dataFam') page = 1;
    else if (pathHash[0] == 'dataOther') page = 2;
    else page = 0;
    changeShowData((page == 0 ? 'ข้อมูลนักศึกษา' : page == 1 ? 'ข้อมูลผู้ปกครอง' : 'ข้อมูลอื่น ๆ'), page);
}


function changeShowData(txt, page) {
    let x = document.getElementsByClassName('btn_showDataUser');
    for (let i = 0; i < x.length-1; i++) {
        if (i == page) {
            document.getElementsByClassName('frm_data')[i].classList.remove('hidden');
            if (i == 2) {
                setTimeout(() => {
                    if (getStatusBook()) {
                        console.log(document.getElementById('txt_building_id').value, document.getElementById('txt_floor_id').value, document.getElementById('txt_room_id').value);
                        is_book(document.getElementById('txt_building_id').value, document.getElementById('txt_floor_id').value, document.getElementById('txt_room_id').value);
                    }
                }, 100); 
            }
        } else {
            try { document.getElementsByClassName('frm_data')[i].classList.add('hidden'); } catch (error) { continue; }
        }
    }
    unenableEditing();
}

function unenableEditing() {
    let x = document.getElementsByClassName("disable");
    let y = document.getElementsByClassName("btnEdit");
    
    for (let i = 0; i < x.length; i++) {
        x[i].disabled = true;
        x[i].classList.add('cursor-not-allowed');
        x[i].classList.add('bg-white');
    }

    for (let i = 0; i < y.length; i++) {
        if(i % 2 == 0) y[i].classList.remove('hidden')
        else y[i].classList.add('hidden')
    }
}

function enableEditing() {
    let x = document.getElementsByClassName("disable");
    for (let i = 0; i < x.length; i++) {
        x[i].disabled = false;
        x[i].classList.add('text-black');
        ['cursor-not-allowed', 'bg-gray-50', 'text-gray-500'].forEach(e => x[i].classList.remove(e));
    }

    let y = document.getElementsByClassName('btnEdit');
    for (let i = 0; i < y.length; i++) {
        if (i % 2 == 0) document.getElementsByClassName('btnEdit')[i].classList.add('hidden');
        else document.getElementsByClassName('btnEdit')[i].classList.remove('hidden');
    }
}

// function selectOption(data, where) {
function selectOption(value, idSelect) {
    document.getElementById(idSelect).selectedIndex = value;
}

function selectOptionByVal(value, idSelect) {
    document.getElementById(idSelect).value = value;
}

function birthdaySet(value) {
    document.getElementById("date_birthday").value = value;
}


function getStatusBook() {
    return (document.getElementById('txt_room_id').value !== "");
}



var str_select_building = "", str_select_floor = "", str_select_room = "";
if (!getStatusBook()) { str_select_building += `<option value="">- ยังไม่จองห้องพัก -</option>`; };
for (let r = 0; r < data_Book[0].length; r++) {
    str_select_building += `<option value="${data_Book[0][r][0]}">${data_Book[0][r][1]}</option>`;
}
document.getElementById('select_Building').innerHTML = str_select_building;

async function is_book(book_id, floor_id, room_id) {
    await inner_select_floor(book_id);
    await inner_select_room(floor_id);
    selectOptionByVal(book_id, 'select_Building');
    selectOptionByVal(floor_id, 'select_Floor');
    selectOptionByVal(room_id, 'select_Room');
}

async function inner_select_floor(book_id) {
    let statusData = false;
    for (let r = 0; r < data_Book[1].length; r++) {
        if (book_id == data_Book[1][r][2]) {
            str_select_floor += `<option value="${data_Book[1][r][0]}">${data_Book[1][r][1]}</option>`;
            statusData = true;
        }
    }    
    if (!statusData) { 
        str_select_room = `<option disabled selected>- ไม่พบห้องพัก -</option>`;
    }
    document.getElementById('select_Floor').innerHTML = str_select_floor;
}

async function inner_select_room(room_id) {
    let statusData = false;
    for (let r = 0; r < data_Book[2].length; r++) {
        if (room_id == data_Book[2][r][2]) {
            str_select_room += `<option value="${data_Book[2][r][0]}">${data_Book[2][r][1]}</option>`;
            statusData = true;
        }
    }
    if (!statusData) { 
        str_select_room = `<option disabled selected>- ไม่พบห้องพัก -</option>`;
    }
    document.getElementById('select_Room').innerHTML = str_select_room;
}


async function newBook(n) {
    if (!getStatusBook()) {
        
        switch (parseInt(n)) {
            case 0:
                str_select_floor = `<option disabled selected value='null'>- โปรดเลือกชั้น -</option>`;
                await inner_select_floor(document.getElementById('select_Building').value);
                break;
            case 1:
                str_select_room = `<option disabled selected value='null'>- โปรดเลือกห้อง -</option>`;
                await inner_select_room(document.getElementById('select_Floor').value);
                break;
        }
    }
}