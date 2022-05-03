var status_book = null;
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
        return true;    
        console.log('status_book', status_book);
        console.log('array_branch', array_branch);
        console.log('array_building', array_building);
        console.log('array_floor', array_floor);
        console.log('array_room', array_room);
        console.log('array_areaBook', array_areaBook);
        console.log('array_book', array_book);
    }
}

function setValuesForBook(status_book, array_branch, array_building, array_floor, array_room, array_areaBook, array_book) {
    this.status_book = status_book;
    this.array_branch = array_branch;
    this.array_building = array_building;
    this.array_floor = array_floor;
    this.array_room = array_room;
    this.array_areaBook = array_areaBook;
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


function changeSelectBranch() {
    push_Room();
}


async function set_selectBranch() {
    let strInnerHtml = "<option disabled>- เลือกสาขา -</option>";
    for (let i = 0; i < array_branch.length; i++) {
        if (array_branch[i].branch_name != '-') {
            strInnerHtml += `<option value="${array_branch[i].branch_id}">${array_branch[i].branch_name}</option>`;
        }
    }
    strInnerHtml += `<option selected value='99999'>- ภาพรวมทุกคณะ & สาขา -</option>`;
    document.getElementById('select_branch').innerHTML = strInnerHtml;
}


async function set_selectBuilding() {
    let strInnerHtml = "<option disabled selected>- เลือกหอ -</option>";
    for (let i = 0; i < array_building.length; i++) {
        strInnerHtml += `<option value="${array_building[i].building_id}">${array_building[i].building_name}</option>`;
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
    console.log(dataPersonBookInRoom)
    for (let r = 0; r < dataPersonBookInRoom.length; r++) {
        strInnerHtml += `
            <a class="hover:underline" target="_blank" href="./sub_member_manage.php?dataStd&std_id=${dataPersonBookInRoom[r].std_id}">
                <input class="Std_Id hidden" type="text" value="${dataPersonBookInRoom[r].std_id}">
                <li class="flex items-center justify-between ml-4 mr-4 mb-2">
                    <span class="text_fullname">${dataPersonBookInRoom[r].std_firstname} ${dataPersonBookInRoom[r].std_lastname}</span>
                    <span class="text_branch">${dataPersonBookInRoom[r].branch_name.split(' ')[1].substring(1, dataPersonBookInRoom[r].branch_name.split(' ')[1].length-1)}</span>
                </li>
            </a>
        `;
    }
    return strInnerHtml;
}


async function push_Room() {
    let strInnerHtml = "";
    let unitRoom = 0;
    let idRoomPush = [];
    for (let indexRoom = 0; indexRoom < array_room.length; indexRoom++) {
        if ((document.getElementById('select_floor').value == array_room[indexRoom].floor_id) 
            && array_room[indexRoom].room_status == '1') {
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

                let buildingGenderForShowRoom = null;
                for (let indexBuilding = 0; indexBuilding < array_building.length; indexBuilding++) {
                    if (document.getElementById('select_building').value == array_building[indexBuilding].building_id) {
                        buildingGenderForShowRoom = array_building[indexBuilding].building_gender;
                        break;
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
                            && (buildingGenderForShowRoom == buildingGender || buildingGender == 2)
                    ) 
                {

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
    if ((unitRoom > 0)) {
        document.getElementById('not_found_this_rooms').classList.add('hidden');
        document.getElementById('section_room').classList.remove('hidden');
        document.getElementById('area_showRoom').innerHTML = strInnerHtml;
    } else {
        document.getElementById('not_found_this_rooms').classList.remove('hidden');
        document.getElementById('section_room').classList.add('hidden');
    }
}

async function main() {
    await getData();
    await set_selectBranch();
    await set_selectBuilding();
}


window.onload = () => {
    main();
}


function showRoomBook(e, idRoom) {
    let fullname = e.getElementsByClassName('text_fullname');
    let branch = e.getElementsByClassName('text_branch');
    let std_ids = e.getElementsByClassName('Std_Id');
    let strOutput = '';

    if (fullname.length != 0) {
        strOutput = "<p style='color: black; font-weight: 600; margin-top: 18px;'>สมาชิกในห้องมีดังนี้</p><p style='margin-top: 12px; color: #111;'>";
    } else {
        strOutput = '';
    }

    document.getElementById('id_room').value = idRoom;
    document.getElementById('number_room').value = e.getElementsByClassName('numberRoom')[0].innerText;
    document.getElementById('limit_member').value = e.getElementsByClassName('limitMember')[0].innerText;

    for (let i = 0; i < fullname.length; i++) {
        strOutput += (`<a class="hover:underline hover:text-red-800" target="_blank" href="./sub_member_manage.php?dataStd&std_id=${std_ids[i].value}"</a>` + fullname[i].innerText + '&nbsp;&nbsp;&nbsp;' + branch[i].innerText) + '</a><br>';  
    }
    
    Swal.fire({
        title: 'ห้องพักหมายเลข '+ e.getElementsByClassName('numberRoom')[0].innerText,
        html: strOutput,
        icon: '',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ปิด',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก'
    })

}


document.getElementById('btnToggleShowRooms').addEventListener('click', () => {
    document.getElementById('area_reportRooms').classList.toggle('hidden')
});