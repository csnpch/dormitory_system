var array_building = null;
var array_floor = null;
var array_room = null;
var array_book = null;


function reportData() {
    if (array_room == null) {
        return false;
    } else {
        return true;
        console.log('array_building', array_building);
        console.log('array_floor', array_floor);
        console.log('array_room', array_room);
        console.log('array_book', array_book);
    }
}


function setValuesForBook(array_building, array_floor, array_room, array_book) {
    this.array_building = array_building;
    this.array_floor = array_floor;
    this.array_room = array_room;
    this.array_book = array_book;
}


async function getData() {
    let checkData = setInterval(() => {
        if (!reportData()) {
            console.log('No data!')
        } else {
            clearInterval(checkData);
        }
    }, 1000);
}


async function main() {
    await getData();
    await set_selectBuilding();
}


async function set_selectBuilding() {
    let strInnerHtml = "<option disabled selected>- เลือกหอ -</option>";
    for (let i = 0; i < array_building.length; i++) {
        strInnerHtml += `<option value="${array_building[i].building_id}">${array_building[i].building_name}</option>`;
    }
    document.getElementById('select_building').innerHTML = strInnerHtml;
}


function set_selectFloor() {
    let strInnerHtml = "<option disabled selected>- เลือกชั้น -</option>";
    for (let i = 0; i < array_floor.length; i++) {
        if (document.getElementById('select_building').value == array_floor[i].building_id) {
            strInnerHtml += `<option value="${array_floor[i].floor_id}">${array_floor[i].floor_name}</option>`;
        }
    }
    document.getElementById('select_floor').innerHTML = strInnerHtml;
}

function appendDataTable() {
    let dataRoom = document.getElementById('dataRoom');
    let str_innerHtml = `<div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-2 gap-y-2">`;
    let countRoom = 0;
    for (let iRoom = 0; iRoom < array_room.length; iRoom++) {
        if (array_room[iRoom].floor_id == document.getElementById('select_floor').value) {
            let idStdForPath = "[";
            let unitPersonRoom = 0;
            for (let iBook = 0; iBook < array_book.length; iBook++) {
                if (array_book[iBook].room_id == array_room[iRoom].room_id) {
                    unitPersonRoom++;
                    idStdForPath += array_book[iBook].std_id + ", ";
                }
            }
            idStdForPath = idStdForPath.substring(0, idStdForPath.length - 2);
            idStdForPath += "]";
            countRoom++;
            str_innerHtml += `
                <div class="bg-white flex flex-row justify-between items-center p-4 border-2 border-black border-opacity-10 rounded-md">
                    <div class="text-center flex flex-row items-center">
                        <input class="checkbox_room checkbox checkbox-sm checkbox-primary mr-2" type="checkbox" name="id_rooms[]" value="${array_room[iRoom].room_id}">
                        <span class="font_sarabun tracking-wider">${array_room[iRoom].room_name}</span>
                    </div>
                    <div class="text-xs">
                        <p onclick="openLinkDataStd(${idStdForPath})" class="font-semibold tracking-widest cursor-pointer hover:underline hover:text-red-800">
                            ${unitPersonRoom}/${array_room[iRoom].room_member}
                        </p>
                    </div>
                </div>
            `;
        }
    }
    str_innerHtml += `</div>`;
    if (countRoom == 0) {
        str_innerHtml = `<p class="w-full mt-6 text-center text-xl text-red-900">ไม่พบห้องพัก</p>`
    }    
    dataRoom.innerHTML = str_innerHtml;
    document.getElementById('checkAllBtn').innerHTML = `
        <div class="flex justify-between items-center w-11/12 md:w-full mx-auto">
            <div class="flex flex-col md:flex-row gap-1">
                <div class="btn btn-xs btn-primary btn-active md:ml-2 font_prompt pt-0.5" onclick="checkBoxAll(1)">เลือกทั้งหมด</div>
                <div class="btn btn-xs btn-active font_prompt pt-0.5" onclick="checkBoxAll(0)">ล้าง</div>
            </div>
            <div onclick="confirmDestroyRoomFormSelect()" class="btn_destroyRoomFormSelectCheck mt-4 bg_card_red_on_hv hover:bg-red-800 cursor-pointer font_prompt text-center text-white rounded-lg h-10 p-4 flex justify-center items-center">
                นำ นศ. ออกจากห้องพักที่เลือก
            </div>
        </div>
    `;

    document.getElementById('areaTable').classList.remove('hidden');
}


function checkBoxAll(statusSelect) {
    for (let i = 0; i < document.getElementsByClassName('checkbox_room').length; i++) {
        document.getElementsByClassName('checkbox_room')[i].checked = (statusSelect == 1 ? true : false);
    }
}

function openLinkDataStd(pathStd) {
    let tmpPathStd = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split('/')[1] + '/' + window.location.pathname.split('/')[2] + '/sub_member_manage.php?dataStd&std_id=';
    for (let i = 0; i < pathStd.length; i++) {
        try {
            window.open(tmpPathStd + pathStd[i]);
        } catch (error) { }
    }
    
}


function confirmDestroyRoomFormSelect() {
    let statusCheck = true;
    for (let i = 0; i < document.getElementsByClassName('checkbox_room').length; i++) {
        if(!document.getElementsByClassName('checkbox_room')[i].checked == false) {
            statusCheck = false;
        }
    }

    if (statusCheck) {
        Swal.fire({
            position: 'center-center',
            icon: 'warning',
            html: 'โปรดเลือกห้องที่ต้องการนำนักศึกษาออก !',
            showConfirmButton: false,
            timer: 1500
        })
    } else { 
        Swal.fire({
            title: 'ต้องการนำ นศ. <br>ออกจากห้องพักที่คุณเลือก ?',
            text: 'โปรดยืนยันการยกเลิกห้องพักของนักศึกษา !!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'โปรดยืนยันการนำ นศ. <br>ออกจากห้องพักที่คุณเลือกอีกครั้ง !',
                    text: 'โปรดยืนยันอีกครั้ง !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementsByClassName('btn_destroyRoomFormSelect')[0].click();
                    }
                })
            }
        })
    }
}


window.onload = () => {
    main();
}


document.getElementsByClassName('btn_destroyRoomFormYearCheck')[0].addEventListener('click', () => {
    if (document.getElementsByClassName('select_year')[0].value != '- เลือกปีที่ต้องการ -') {
        Swal.fire({
            title: 'คุณต้องการนำ<br>นศ. ปี '+document.getElementsByClassName('select_year')[0].value+' ออกจากห้องพัก ?',
            text: 'โปรดยืนยันการยกเลิกห้องพักของนักศึกษา !!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'คุณต้องการนำ<br>นศ. ปี '+document.getElementsByClassName('select_year')[0].value+' ออกจากห้องพัก<br>โปรดยืนยันอีกครั้ง !',
                    text: 'โปรดยืนยันอีกครั้ง !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementsByClassName('btn_destroyRoomFormYear')[0].click();
                    }
                })
            }
        })
    } else {
        Swal.fire({
            title: 'โปรดเลือกปีที่ต้องการ',
            text: '',
            icon: 'warning',
            showConfirmButton: false,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            timer: 1000
        })
    }
});     


document.getElementsByClassName('btn_destroyRoomAllStdCheck')[0].addEventListener('click', () => {
    Swal.fire({
        title: 'คุณต้องการนำนักศึกษาทุกคน<br>ออกจากห้องพัก ?',
        text: 'โปรดยืนยันการยกลิกห้องพักของนักศึกษาทุกคน !!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'โปรดยืนยันการนำนักศึกษาทุกคน<br>ออกจากห้องพักอีกครั้ง !',
                text: 'โปรดยืนยันอีกครั้ง !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementsByClassName('btn_destroyRoomAllStd')[0].click();
                }
            })
        }
    })
});