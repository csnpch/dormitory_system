function toggleBranch(index) {
    document.getElementsByClassName('branchContainer')[index].classList.toggle('hidden');
}

document.getElementById('fac_add_item').addEventListener('click', () => {
    document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
    document.getElementsByClassName('area_add_fac')[0].classList.toggle('hidden');
});

document.getElementById('branch_add_item').addEventListener('click', () => {
    document.getElementsByClassName('overlay')[0].classList.toggle('hidden');
    document.getElementsByClassName('area_add_branch')[0].classList.toggle('hidden');
});

function clearPopup() {
    document.getElementsByClassName('overlay')[0].classList.add('hidden');
    document.getElementsByClassName('area_add_branch')[0].classList.add('hidden');
    document.getElementsByClassName('area_add_fac')[0].classList.add('hidden');
    document.getElementsByClassName('popupEditBranch')[0].classList.add('hidden');
    document.getElementsByClassName('popupEditFac')[0].classList.add('hidden');
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
       clearPopup();
    }
};


function popupEditFac(fac_id, fac_name) {
    document.getElementsByClassName('overlay')[0].classList.remove('hidden');
    document.getElementsByClassName('popupEditFac')[0].classList.remove('hidden');
    document.getElementsByClassName('txt_fac_id_edit')[0].value = fac_id;
    document.getElementsByClassName('txt_fac_name_edit')[0].value = fac_name;
}

function popupEditBranch(branch_id, branch_name, fac_id) {
    console.log(branch_id, branch_name, fac_id)
    document.getElementsByClassName('overlay')[0].classList.remove('hidden');
    document.getElementsByClassName('popupEditBranch')[0].classList.remove('hidden');
    document.getElementsByClassName('select_fac_edit')[0].value = fac_id;
    document.getElementsByClassName('txt_branch_id_edit')[0].value = branch_id;
    document.getElementsByClassName('txt_branch_name_edit')[0].value = branch_name;
}

function popupDelFac(id, text) {
    document.getElementsByClassName('txt_id_fac_branch_del')[0].value = id;

    Swal.fire({
        title: 'ลบคณะ : ' +text+' ?',
        text: 'ต้องการลบคณะนี้ออกจากระบบใช่หรือไม่ !!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันการลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementsByClassName('btn_delFac')[0].click();
        }
    })
}

function popupDelBranch(id, text) {

    document.getElementsByClassName('txt_id_fac_branch_del')[0].value = id;

    Swal.fire({
        title: 'ลบสาขา : ' +text+' ?',
        text: 'ต้องการลบสาขานี้ออกจากระบบใช่หรือไม่ !!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันการลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementsByClassName('btn_delBranch')[0].click();
        }
    })

}