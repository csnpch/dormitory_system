function setStatusCheckbox() {
    if (document.getElementsByClassName('checkboxStatusDestroy')[0].checked) {
        document.getElementsByClassName('status_destroyStdFormYear')[0].value = 1;
    } else {
        document.getElementsByClassName('status_destroyStdFormYear')[0].value = 0;
    }

    if (document.getElementsByClassName('checkboxStatusDestroy')[1].checked) {
        document.getElementsByClassName('status_destroyAllStd')[0].value = 1;
    } else {
        document.getElementsByClassName('status_destroyAllStd')[0].value = 0;
    }
}

document.getElementsByClassName('btn_destroyStdFormYearCheck')[0].addEventListener('click', () => {
    setStatusCheckbox();
    if (document.getElementsByClassName('select_year')[0].value != '- เลือกปีที่ต้องการ -') {
        Swal.fire({
            title: 'คุณต้องการลบข้อมูล<br>นศ. ปี '+document.getElementsByClassName('select_year')[0].value+' ออกจากระบบ ? <span class="text-sm text-red-900">(1/2)</span>',
            text: 'โปรดยืนยันการลบข้อมูลของนักศึกษา !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'โปรดยืนยันการลบข้อมูล<br>นศ. ปี '+document.getElementsByClassName('select_year')[0].value+' ออกจากระบบ อีกครั้ง! <span class="text-sm text-red-900">(2/2)</span>',
                    text: 'โปรดยืนยันอีกครั้ง !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementsByClassName('btn_destroyStdFormYear')[0].click();
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


document.getElementsByClassName('btn_destroyAllStdCheck')[0].addEventListener('click', () => {
    setStatusCheckbox();
    Swal.fire({
        title: 'คุณต้องการนำนักศึกษาทุกคน<br>ออกจากห้องพัก ? <span class="text-sm text-red-900">(1/3)</span>',
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
                title: 'โปรดยืนยันการนำนักศึกษาทุกคน<br>ออกจากห้องพักอีกครั้ง! <span class="text-sm text-red-900">(2/3)</span>',
                text: 'โปรดยืนยันอีกครั้ง !!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'โปรดยืนยันการนำนักศึกษาทุกคน<br>ออกจากห้องพักอีกครั้ง! <span class="text-sm text-red-900">(3/3)</span>',
                        text: 'โปรดยืนยันอีกครั้ง !',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementsByClassName('btn_destroyAllStd')[0].click();
                        }
                    })
                }
            })
        }
    })
});
