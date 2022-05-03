// Add item
function toggleSubMenu_AddItem(how) {
    switch (how) {
        case 1:
            document.getElementById('popup_addItem').classList.toggle('hidden');
            break;
        case 0:
            document.getElementById('popup_addItem').classList.add('hidden');
            break;
    }
}

document.getElementById('add_item').addEventListener('click', () => {
    toggleSubMenu_AddItem(1);
})

// Edit room
function editFloorRoom(elements, where) {
    document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
    document.getElementById('edit_room').classList.toggle('hidden');
    switch (parseInt(where)) {
        case 0:
            document.getElementById('change_name_room').classList.add('hidden');
            document.getElementById('change_name_floor').classList.remove('hidden');
            document.forms["frm_edit_floor"]["txt_floor_id"].value = elements.getElementsByClassName('floor_id')[0].value;
            document.forms["frm_edit_floor"]["txt_floor_name"].value = elements.getElementsByClassName('floor_name')[0].value;
            break;
        case 1:
            document.getElementById('change_name_floor').classList.add('hidden');
            document.getElementById('change_name_room').classList.remove('hidden');
            document.forms["frm_edit_room"]["txt_floor_only_id"].value = elements.getElementsByClassName('floor_id_only')[0].value;
            document.forms["frm_edit_room"]["txt_room_id"].value = elements.getElementsByClassName('floor_room_id')[0].value;
            document.forms["frm_edit_room"]["txt_room_name"].value = elements.getElementsByClassName('floor_room_name')[0].value;
            document.forms["frm_edit_room"]["txt_room_member"].value = elements.getElementsByClassName('room_member')[0].value;
            document.forms["frm_edit_room"]["select_status"].value = elements.getElementsByClassName('room_status')[0].value;
            document.forms["frm_edit_room"]["select_floor"].value = elements.getElementsByClassName('floor_id_only')[0].value;
            break;
    }
}

for (let i = 0; i < 2; i++) {
    document.getElementsByClassName('cancleEditFloor')[i].addEventListener('click', () => {
        setTimeout(() => {
            document.getElementById('edit_room').classList.toggle('hidden');
            document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
        }, 200);
    })
}

// Edit name building
document.getElementById('btn_editNameBuilding').addEventListener('click', () => {
    document.getElementById('btn_editNameBuilding').classList.toggle('hidden');
    document.getElementById('btn_saveNameBuilding').classList.toggle('hidden');
    document.forms["editName"]["txt_nameBuilding"].classList.toggle('hidden');
    document.getElementById('showNameBuilding').classList.toggle('hidden');
    document.forms["editName"]["txt_nameBuilding"].focus();
    document.forms["editName"]["txt_nameBuilding"].setSelectionRange(
        document.forms["editName"]["txt_nameBuilding"].value.length, 
        document.forms["editName"]["txt_nameBuilding"].value.length
    );
    document.getElementById("select_building_status").disabled = false;
})

function toggleRoomShow(index) {
    toggleSubMenu_AddItem(0);
    document.getElementsByClassName('room')[index].classList.toggle('hidden');
    document.getElementsByClassName('main_tools')[index].classList.toggle('hidden');
    ['rotate-90', 'mt-1.5'].forEach(e => { document.getElementsByClassName('fa-angle-down')[index].classList.toggle(e) });
}

// Change layout grid
window.addEventListener('scroll', () => {
    let checkScroll = window.scrollY;
    console.log();
    if (checkScroll > 340 && window.screen.width > 1000) {
        document.getElementsByClassName("changeWidth")[0].classList.add('mb-20');
        document.getElementById("showData").classList.remove('md:grid-cols-2');
        document.getElementsByClassName('changeWidth')[0].classList.remove('lg:border-l-2');
        document.getElementsByClassName('changeWidth')[0].classList.remove('lg:border-l-2');
        ['sm:pl-10', 'sm:p-4', 'mb-4', '-mt-10', 'md:mt-0', 'widthShowData', 'unWidthShow'].forEach(
            e => { document.getElementsByClassName('changeWidth')[0].classList.remove(e) }
        );
        document.getElementsByClassName('arrow_go_up')[0].classList.remove('hidden');
        let elementRoom = document.getElementsByClassName('tools_room');
        for (let i = 0; i < elementRoom.length; i++) {
            elementRoom[i].classList.remove('sm:pr-20');
        }                
    } else {
        document.getElementById("showData").classList.add('md:grid-cols-2');
        document.getElementsByClassName("changeWidth")[0].classList.remove('widthShowData');
        document.getElementsByClassName("changeWidth")[0].classList.remove('sm:pr-20');
        document.getElementsByClassName('arrow_go_up')[0].classList.add('hidden');
        ['sm:pl-10', 'sm:p-4', 'mb-4', '-mt-10', 'md:mt-0', 'widthShowData', 'unWidthShow'].forEach(
            e => { document.getElementsByClassName('changeWidth')[0].classList.add(e) }
        );
        let elementRoom = document.getElementsByClassName('tools_room');
        for (let i = 0; i < elementRoom.length; i++) {
            elementRoom[i].classList.add('sm:pr-20');
        }
    }
})

function goUp() { window.scrollTo(0, 0); }

document.getElementById('floor_add_item').addEventListener('click', () => {
    setTimeout(() => {
        toggleSubMenu_AddItem(0);
        document.getElementsByClassName('add_item_floor_room')[0].classList.remove('hidden');
        document.getElementsByClassName('add_item_floor')[0].classList.remove('hidden');
        document.getElementsByClassName('overlay')[0].classList.remove('hidden');
    }, 200);
})

document.getElementById('room_add_item').addEventListener('click', () => {
    setTimeout(() => {
        toggleSubMenu_AddItem(0);
        document.getElementsByClassName('add_item_floor_room')[0].classList.remove('hidden');
        document.getElementsByClassName('add_item_room')[0].classList.remove('hidden');
        document.getElementsByClassName('overlay')[0].classList.remove('hidden');
    }, 200);
})


for (let i = 0; i < document.getElementsByClassName('cancleAddItem').length; i++) {
    document.getElementsByClassName('cancleAddItem')[i].addEventListener('click', () => {
        setTimeout(() => {
            document.getElementsByClassName('overlay')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_floor_room')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_room')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_floor')[0].classList.add('hidden');
        }, 200);
    })
}

try {
    document.getElementsByClassName('cancleAddItemRoom')[0].addEventListener('click', () => {
        setTimeout(() => {
            document.getElementsByClassName('overlay')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_floor_room')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_room')[0].classList.add('hidden');
            document.getElementsByClassName('add_item_floor')[0].classList.add('hidden');
        }, 200);
    })
} catch (error) { }

function confirm_delete(elements, where, indexRoom, indexFloor) {
    Swal.fire({
        title: 'ต้องการลบ '+ elements.getElementsByClassName('nameDel')[0].value,
        html: "</p>"+"<span style='font-size: 1rem;'><p style='color: Brown; font-weight: 500;'>โปรดทราบ !</p>"+
            "<p style='color: Brown;'>หากชั้นหรือห้องมีผู้อาศัยอยู่ จะมีผลเสียต่อข้อมูลในระบบ<br>หากมีความจำเป็นให้ปรึกษาเจ้าหน้าที่ก่อน ขอบคุณ!!</p></span>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ยืนยัน',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'โปรดยืนยันการลบ '+ elements.getElementsByClassName('nameDel')[0].value + " อีกครั้ง",
                html: "</p>"+"<span style='font-size: 1rem;'><p style='color: Brown; font-weight: 500;'>โปรดทราบ !</p>"+
                        "<p style='color: Brown;'>หากชั้นหรือห้องมีผู้อาศัยอยู่ จะมีผลเสียต่อข้อมูลในระบบ<br>หากมีความจำเป็นให้ปรึกษาเจ้าหน้าที่ก่อน ขอบคุณ!!</p></span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ฉันแน่ใจ, ยืนยันการลบ',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    switch (where) {
                        case 0:
                            document.getElementsByClassName('btn_del_floor')[indexRoom].click();
                            break;
                        case 1:
                            document.getElementsByClassName('item_floor')[indexFloor].getElementsByClassName('btn_del_room')[indexRoom].click();
                            break;
                    }
                }
            })
        }
    })
}