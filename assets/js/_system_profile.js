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

function updateData(idWhere) {
    Swal.fire({
        title: 'คุณต้องแก้ไขข้อมูลใช่หรือไม่',
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
    // pathHash = pathHash.slice(((pathHash).length)-8, pathHash.length);
    pathHash = pathHash.split("?");
    if (pathHash[1] == 'dataStd') page = 0;
    else if (pathHash[1] == 'dataFam') page = 1;
    else if (pathHash[1] == 'dataOther') page = 2;
    else page = 0;
    changeShowData((page == 0 ? 'ข้อมูลนักศึกษา' : page == 1 ? 'ข้อมูลผู้ปกครอง' : 'ข้อมูลอื่น ๆ'), page);
}


function changeShowData(txt, page) {

    document.getElementById('txtNav').innerHTML = txt;
    let x = document.getElementsByClassName('btn_showDataUser');
    for (let i = 0; i < x.length-1; i++) {
        if (i == page) {
            document.getElementsByClassName('frm_data')[i].classList.remove('hidden');
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
        x[i].classList.add('bg-gray-100');
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
        ['cursor-not-allowed', 'bg-gray-100', 'text-gray-600'].forEach(e => x[i].classList.remove(e));
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

function birthdaySet(value) {
    document.getElementById("date_birthday").value = value;
}