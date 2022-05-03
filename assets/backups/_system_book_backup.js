window.onload = () => {
    let floor = document.getElementById('select_floor');
    if (floor.value != '0')
        document.getElementById('section_room').classList.remove('hidden');
    
    let text = '';
    let alert = false;
    let nameFloor = floor.options[floor.selectedIndex].text;
    switch (parseInt(document.getElementById('std_status').value)) { 
        case 1: 
            if (nameFloor === 'ชั้น 3') {
                text = 'ชั้น 3 สำหรับนักศึกษาเก่าของหอพัก';
                alert = true;
            } else if (nameFloor === 'ชั้น 2') {
                text = 'ชั้น 2 สำหรับนักศึกษาเก่าของหอพัก';
                alert = true;
            } else if (nameFloor === 'ชั้น 1') {
                text = 'ชั้น 1 สำหรับเจ้าหน้าที่หอพัก';
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
        break;
    }
}

function setStatusRoom(nRoom, nUnitPerson) {
    let room = document.getElementsByClassName('room');
    let unitPerson = document.getElementsByClassName('unitPerson');
    let limitMember = document.getElementsByClassName('limitMember');

    switch(Number(nUnitPerson)) { 
        case 0:
            ['pt-3', 'pb-1'].forEach(e => document.getElementsByClassName('dropdown-room')[nRoom].classList.remove(e));
    }

    unitPerson[Number(nRoom)].innerHTML = nUnitPerson;
    if (Number(unitPerson[nRoom].innerHTML) >= Number(limitMember[nRoom].innerHTML)) room[nRoom].classList.add('bg_red');
    else if (Number(unitPerson[nRoom].innerHTML) > 2) room[nRoom].classList.add('bg_orange');
    else if (Number(unitPerson[nRoom].innerHTML) >= 0) room[nRoom].classList.add('bg_green');
}

function get_select_option_book(n) {
    let floor = document.getElementById('select_floor').value;
    switch (n) { case 1: floor = '0'; }
    window.location = 'system_book.php?' + 'branch=' + document.getElementById('select_branch').value +
                        '&' + 'building=' + document.getElementById('select_building').value + 
                        '&' + 'floor=' + floor;
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
    document.getElementById('number_room').value = Number(e.getElementsByClassName('numberRoom')[0].innerText);
    document.getElementById('limit_member').value = Number(e.getElementsByClassName('limitMember')[0].innerText);

    for (let i = 0; i < fullname.length; i++) {
        strOutput += (fullname[i].innerText + '&nbsp;&nbsp;&nbsp;' + branch[i].innerText) + '<br>';  
    }
    
    if (!(Number(e.getElementsByClassName('unitPerson')[0].innerText) >= Number(e.getElementsByClassName('limitMember')[0].innerText))) {
        Swal.fire({
            title: 'จองห้องพัก '+ e.getElementsByClassName('numberRoom')[0].innerText,
            html: strOutput+"</p>"+"<span style='font-size: 1rem;'><p style='color: Brown; font-weight: 500;'>โปรดทราบ !</p>"+
                            "<p style='color: Brown;'>หากได้ทำการจองแล้วจะไม่สามารถเปลี่ยนห้องได้</p></span>",
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
            window.location.href = './system_book.php';
            // window.location.reload();
        }, 1000));
    }

}

function reshowRoom() {
    let x = document.getElementsByClassName('room');

    for (let i = 0; i < x.length; i++)
        x[i].classList.add('hidden');
    document.getElementById('select_floor').selectedIndex = '0';

}

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

function callDateRange(status, value_date_range) {
    // let date_range = document.getElementsByClassName('txt_timeRange')[0].value.split(' - ')[(status == 0 ? 1 : 0)].split('/');
    let date_range = value_date_range.split(' - ')[(parseInt(status) === 0 ? 1 : 0)].split('/');

    // nowTime = new Date();
    // let hour = 23-(nowTime.getHours());
    // let min = 59-(nowTime.getMinutes());
    // let sec = 60-(nowTime.getSeconds());
    
    // let day = ((parseInt(date_range[0]) - parseInt(nowTime.getDate())));
    // let totalDay = 0; 

    // let monthStart = nowTime.getMonth();
    // let yearStart = nowTime.getFullYear();
    // let controlLoop = 0;


    // if (parseInt(date_range[1])-parseInt(nowTime.getMonth()) < 0) {
    //     controlLoop = ((parseInt(nowTime.getMonth() - parseInt(date_range[1]))) - parseInt(date_range[1]));
    //     if (parseInt(yearStart) < parseInt(date_range[2])) {
    //         controlLoop += parseInt(date_range[2]);
    //         controlLoop--;
    //     }
    //     controlLoop--;
    //     ++totalDay;
    // } else {
    //     controlLoop = parseInt(date_range[1]) - parseInt(nowTime.getMonth());
    // }
    
    // for (let i = 1; i < controlLoop; i++) {
    //     totalDay += checkDate(monthStart, yearStart);

    //     monthStart++;
    //     if (monthStart > 12) {
    //         monthStart = 1;
    //         yearStart++;
    //     }
    // }

    // day = (totalDay - (checkDate(date_range[1]) - parseInt(date_range[0])) );
    // // day++;
    // if (day > 99) {
    //     day = 99;
    // }

    let day = 0;
    let hour = 0;
    let min = 0;
    let sec = 10;
    changeTimeCount('day', day);
    changeTimeCount('hour', hour);
    changeTimeCount('min', min);
    
    clockCount = setInterval(() => {
    
        changeTimeCount('sec', --sec);

        if (day <= 0 && hour <= 0 && min <= 0 && sec < 1) {
            clearInterval(clockCount);
            changeTimeCount('day', 0);
            document.getElementById('toggleStatus').click();
        }

        if (sec <= 0) {
            sec = 59;
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
            hour = 24;
            if (day > 0) {
                changeTimeCount('hour', hour);
                changeTimeCount('day', --day);
            } 
        }

        if (day < 1) { changeTimeCount('day', 0); }
        

    }, 1000);
    
}
