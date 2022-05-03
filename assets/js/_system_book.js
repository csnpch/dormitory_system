var status_book = null;
var array_dataUser = null;
var array_branch = null;
var array_building = null;
var array_floor = null;
var array_room = null;
var array_areaBook = null;
var array_book = null;

function reportData() {
    if (status_book == null) {
        return false;
    } else {
        // console.log('status_book', status_book);
        // console.log('array_dataUser', array_dataUser);
        // console.log('array_branch', array_branch);
        // console.log('array_building', array_building);
        // console.log('array_floor', array_floor);
        // console.log('array_room', array_room);
        // console.log('array_areaBook', array_areaBook);
        // console.log('array_book', array_book);
        return true;    
    }
}

function setValuesForBook(status_book, array_dataUser, array_branch, array_building, array_floor, array_room, array_areaBook, array_book) {
    this.status_book = status_book;
    this.array_dataUser = array_dataUser;
    this.array_branch = array_branch;
    this.array_building = array_building;
    this.array_floor = array_floor;
    this.array_room = array_room;
    this.array_areaBook = array_areaBook;
    this.array_book = array_book;
}

function getData() {
    let checkData = setInterval(() => {
        if (!reportData()) {
            console.log('No data!')
        } else {
            clearInterval(checkData);
        }
    }, 1000);
}


function showRoomBook(e, idRoom) {
    let fullname = e.getElementsByClassName('text_fullname');
    let branch = e.getElementsByClassName('text_branch');
    let strOutput = '';

    if (fullname.length != 0) {
        strOutput = "<p style='color: black; font-weight: 600;'>สมาชิกในห้องมีดังนี้</p><p style='margin-top: 4px; color: #111; margin-bottom: 1rem;'>";
    } else {
        strOutput = '';
    }

    document.getElementById('id_room').value = idRoom;
    document.getElementById('number_room').value = e.getElementsByClassName('numberRoom')[0].innerText;
    document.getElementById('limit_member').value = e.getElementsByClassName('limitMember')[0].innerText;

    for (let i = 0; i < fullname.length; i++) {
        strOutput += (fullname[i].innerText + '&nbsp;&nbsp;&nbsp;' + branch[i].innerText) + '<br>';  
    }
    
    if (!(Number(e.getElementsByClassName('unitPerson')[0].innerText) >= Number(e.getElementsByClassName('limitMember')[0].innerText))) {
        Swal.fire({
            title: 'จองห้องพัก ' + e.getElementsByClassName('numberRoom')[0].innerText,
            html: strOutput + "</p>"+"<span style='font-size: 1rem;'><p style='color: Brown; font-weight: 500;'>โปรดตรวจสอบหมายเลขห้องให้ถูกต้องก่อนทำการจอง</p></span>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ยืนยันการจอง',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('submitBook').click();
            }
        })
    } else if ((Number(e.getElementsByClassName('unitPerson')[0].innerText) < 1)) {
        e.getElementsByClassName('dorpdown-room').classList.remove('pt-3');
    } else {
        Swal.fire({
            title: 'ห้อง '+ e.getElementsByClassName('numberRoom')[0].innerText +' เต็มแล้ว',
            text: 'กรุณาเลือกจองห้องอื่น',
            icon: 'error',
            showConfirmButton: false,
            showCancelButton: false,
            timer: 1500
        }).then(setTimeout(() => {
            window.location.reload();
        }, 2000));
    }

}


function changeSelectBranch() {
    push_Room();
}


function set_selectBranch() {
    let strInnerHtml = "<option disabled>- เลือกสาขา -</option>";
    for (let i = 0; i < array_branch.length; i++) {
        if (array_dataUser[1].fac_id == array_branch[i].fac_id) {
            strInnerHtml += `<option value="${array_branch[i].branch_id}">${array_branch[i].branch_name}</option>`;
        }
    }
    strInnerHtml += `<option value='99999'>- ภาพรวมทุกคณะ & สาขา -</option>`;
    document.getElementById('select_branch').innerHTML = strInnerHtml;
    document.getElementById('select_branch').value = array_dataUser[0].branch_id;
}


function set_selectBuilding() {
    console.log(array_building);
    console.log(array_dataUser);
    let strInnerHtml = "<option disabled selected>- เลือกหอ -</option>";
    for (let i = 0; i < array_building.length; i++) {
        if(array_dataUser[0].std_sex == array_building[i].building_gender || array_building[i].building_gender == '2') {
            strInnerHtml += `<option value="${array_building[i].building_id}">${array_building[i].building_name}</option>`;
        }
    }
    document.getElementById('select_building').innerHTML = strInnerHtml;
}


function set_selectFloor() {
    if (document.getElementById('select_floor').value != 'null') {
        document.getElementById('section_room').classList.add('hidden');
    }
    let strInnerHtml = "<option disabled selected>- เลือกชั้น -</option>";
    for (let i = 0; i < array_floor.length; i++) {
        if (document.getElementById('select_building').value == array_floor[i].building_id) {
            strInnerHtml += `<option value="${array_floor[i].floor_id}">${array_floor[i].floor_name}</option>`;
        }
    }
    document.getElementById('select_floor').innerHTML = strInnerHtml;
}


async function pushMemberDataInRoomBook(dataPersonBookInRoom) {
    strInnerHtml = "";
    for (let r = 0; r < dataPersonBookInRoom.length; r++) {
        strInnerHtml += `
            <li class="flex items-center justify-between ml-4 mr-4 mb-2">
                <span class="text_fullname">${dataPersonBookInRoom[r].std_firstname} ${dataPersonBookInRoom[r].std_lastname}</span>
                <span class="text_branch">${dataPersonBookInRoom[r].branch_name.split(' ')[1].substring(1, dataPersonBookInRoom[r].branch_name.split(' ')[1].length-1)}</span>
            </li>
        `;
    }
    return strInnerHtml;
}


function check_premisionFloorBook() {
    let floor = document.getElementById('select_floor');
    let text = '';
    let alert = false;
    let nameFloor = floor.options[floor.selectedIndex].text;
    if (nameFloor == 'ชั้น 3' && parseInt(array_dataUser[0].std_status) == 1) {
        text = 'ชั้น 3 โดยปกติแล้วจะเป็นชั้น<br>สำหรับนักศึกษาเก่าของหอพัก<br>หากมีความจำเป็นก็สามารถจองได้ปกติ';
        alert = true;
    } else if (nameFloor == 'ชั้น 2' && parseInt(array_dataUser[0].std_status) == 1) {
        text = 'ชั้น 2 โดยปกติแล้วจะเป็นชั้น<br>สำหรับนักศึกษาเก่าของหอพัก<br>หากมีความจำเป็นก็สามารถจองได้ปกติ';
        alert = true;
    } else if (nameFloor == 'ชั้น 1') {
        text = 'ชั้น 1 สำหรับเจ้าหน้าที่หอพัก !!';
        alert = true;
    }
    if (alert) {
        Swal.fire({
            title: 'โปรดทราบ !!',
            html: "<p class='text-gray-900 text-sm md:text-2xl overflow-hidden'>"+text+"</p>",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#2c67c7',
            confirmButtonText: 'เข้าใจแล้ว'
        })
    }
}

async function push_Room() {
    let strInnerHtml = "";
    let unitRoom = 0;
    let idRoomPush = [];
    for (let indexRoom = 0; indexRoom < array_room.length; indexRoom++) {
        if (document.getElementById('select_floor').value == array_room[indexRoom].floor_id && array_room[indexRoom].room_status == '1') {
            let unitPersonBookInRoom = 0;
            let dataPersonBookInRoom = [];
            for (let indexBook = 0; indexBook < array_book.length; indexBook++) {
                if (array_book[indexBook].room_id == array_room[indexRoom].room_id) {
                    dataPersonBookInRoom.push(array_book[indexBook]);
                    unitPersonBookInRoom++;
                }
            }

            for (let indexAreaBook = 0; indexAreaBook < array_areaBook.length; indexAreaBook++) {
                let buildingGender = null;
                for (let indexFloor = 0; indexFloor < array_floor.length; indexFloor++) {
                    if (array_room[indexRoom].floor_id == array_floor[indexFloor].floor_id) {
                        for (let indexBuilding = 0; indexBuilding < array_building.length; indexBuilding++) {
                            if (array_floor[indexFloor].building_id == array_building[indexBuilding].building_id) {
                                buildingGender = array_building[indexBuilding].building_gender;
                                break;
                            }
                        }
                    }
                }
                
                if (
                    (
                        ((document.getElementById('select_branch').value == array_areaBook[indexAreaBook].branch_id
                        && (array_areaBook[indexAreaBook].room_id == array_room[indexRoom].room_id)) || 
                        (document.getElementById('select_branch').value == '99999' 
                        && array_areaBook[indexAreaBook].room_id == array_room[indexRoom].room_id)) 
                        && parseInt(array_room[indexRoom].room_status) == 1
                    ) || ((array_areaBook[indexAreaBook].branch_id == null 
                            && array_areaBook[indexAreaBook].room_id == array_room[indexRoom].room_id)) 
                            && (array_dataUser[0].std_sex == buildingGender || buildingGender == 2)
                    ) {

                    idRoomPush.push(parseInt(array_room[indexRoom].room_id));
                    strInnerHtml += `
                        <div class="room relative w-full h-20 text-right rounded-lg cursor-pointer transition-all duration-400 
                        ${
                            (unitPersonBookInRoom < (parseInt(array_room[indexRoom].room_member) > 4 ? parseInt(array_room[indexRoom].room_member) - 2 : parseInt(array_room[indexRoom].room_member) - 1) ? 
                            'bg_green' : (unitPersonBookInRoom >= parseInt(array_room[indexRoom].room_member) ? 'bg_red' : 'bg_orange'))
                        }"
                                onclick="showRoomBook(this, ${array_room[indexRoom].room_id})">
                            <p class="defocus tracking-tighter mr-2 mt-2 text-sm font_kanit font-light">
                                <span class="unitPerson">${unitPersonBookInRoom}</span>
                                <span class="">/</span>
                                <span class="limitMember">${array_room[indexRoom].room_member}</span>
                            </p>
                            <p class="numberRoom flex w-full justify-center items-center -mt-1 text-3xl font_kanit tracking-widest">
                                ${array_room[indexRoom].room_name}${(array_areaBook[indexAreaBook].branch_id == null ? '*' : '')}
                            </p>
                            <input class="roomShow_id hidden" type="text" value="${array_room[indexRoom].room_id}">
                            <div class="${(unitPersonBookInRoom == 0 ? '' : 'dropdown-room')} z-20 hidden font-medium absolute w-60 text-sm mt-5 pt-3 pb-1 shadow-2xl">
                                <ul>
                                    ${await pushMemberDataInRoomBook(dataPersonBookInRoom)}
                                </ul>
                            </div>
                        </div>
                    `;
                    unitRoom++;
                }
            }
        }
    }
    check_premisionFloorBook();
    if ((unitRoom > 0)) {
        document.getElementById('not_found_this_rooms').classList.add('hidden');
        document.getElementById('section_room').classList.remove('hidden');
        document.getElementById('area_showRoom').innerHTML = strInnerHtml;
    } else {
        document.getElementById('not_found_this_rooms').classList.remove('hidden');
        document.getElementById('section_room').classList.add('hidden');
    }
}


function checkStatusBook() {
    if (parseInt(status_book.status_switch) == 1 || parseInt(status_book.status_switch) == 3) {
        document.getElementById('areaBook').classList.remove('hidden');
        document.getElementById('ManualSystemBook').classList.remove('hidden'); 
        document.getElementsByClassName('statusTimeoutAutomateSystemBook')[1].classList.remove('hidden');
        if (parseInt(status_book.status_switch) == 3) {
            document.getElementById('AutomateSystemBook').classList.remove('hidden');
            document.getElementsByClassName('spaceAreaManualSystemBook')[0].classList.remove('mb-20');
            document.getElementsByClassName('spaceAreaManualSystemBook')[0].classList.add('mb-6');
        }
    } else if (parseInt(status_book.status_switch) == 2) {
        document.getElementsByClassName('statusTimeoutAutomateSystemBook')[0].classList.remove('hidden');
        document.getElementById('areaBook').classList.remove('hidden');
        document.getElementById('AutomateSystemBook').classList.remove('hidden');
        setInterval(() => {
            if (document.getElementById('ManualSystemBook').classList.value != 'hidden') {
                document.getElementById('ManualSystemBook').classList.add('hidden'); 
            }
        }, 1000);
    } else if (parseInt(status_book.status_switch) == 0) {
        Swal.fire({
            title: 'ระบบจองห้องพักปิดอยู่',
            html: 'ทางหอจะแจ้งวันเปิดเข้าจองให้ทราบ <br>โปรดติดตามข่าวสารของหอพัก !',
            icon: 'error',
            showConfirmButton: true,
            showCancelButton: false,
            confirmButtonColor: '#cc0c62',
            confirmButtonText: 'เข้าใจแล้ว'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = './system_main.php';
            } else {
                window.location = './system_main.php';
            }
        })
    }
}

async function main() {
    await getData();
    await set_selectBranch();
    await set_selectBuilding();
    await checkStatusBook();
}


window.onload = () => {
    main();
    setTimeout(() => {
        window.location.reload();
    }, 1200000);
}




// functions for cooldown

function changeTimeCount(idElement, value) {
    document.getElementById(idElement).style = '--value:' + value;
}

function checkDate(m, y) {
    switch (parseInt(m)) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
        case 4:
        case 6:
        case 9:
        case 11: 
            return 30;
        case 2:
            if (parseInt(y) % 4 == 0) { return 29; } 
            else { return 28; }
        default: 
            return 31;
    }
}


function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function datediff(first, second) {
    return (Math.round((second-first)/(1000*60*60*24)));
}


function callDateRange(statusDateRage, value_date_range_old) {
    // let date_range_old = document.getElementsByClassName('txt_timeRange')[0].value.split(' - ')[(statusDateRage == 0 ? 1 : 0)].split('/');
    let date_range = value_date_range_old.split(' - ')[(parseInt(statusDateRage) == 0 ? 1 : 0)];
    console.log(date_range);
    nowTime = new Date();
    let hour = 23-(nowTime.getHours());
    let min = 59-(nowTime.getMinutes());
    let sec = 59-(nowTime.getSeconds());
    let day = (datediff(parseDate(nowTime.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }).split(',')[0]), parseDate(date_range)))
    
    if (day < 0) {
        day = 0;
        hour = 0;
        min = 0;
        sec = 0;
    } else if (day > 99) {
        day = 99;
    }

    document.getElementById('5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833').value = day;

    changeTimeCount('day', day);
    changeTimeCount('hour', hour);
    changeTimeCount('min', min);
    
    clockCount = setInterval(() => {
    
        changeTimeCount('sec', --sec);

        if (day <= 0 && hour <= 0 && min <= 0 && sec < 1) {
            clearInterval(clockCount);
            changeTimeCount('day', 0);
            setTimeout(() => {
                document.getElementById('3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390').click();
            }, 1000);
        }

        if (sec <= 0) {
            sec = 60;
            if (min > 0 ) {
                changeTimeCount('min', --min);
            }
        }

        if (hour > 0 && min == 0) {
            min = 59;
            changeTimeCount('min', min);
            changeTimeCount('hour', --hour);
        }
        
        if (hour <= 0 && day != 0) {
            hour = 23;
            if (day > 0) {
                changeTimeCount('hour', hour);
                changeTimeCount('day', --day);
            } 
        }

        if (day < 1) { changeTimeCount('day', 0); }
        

    }, 1000);
    
}
