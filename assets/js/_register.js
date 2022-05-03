var inputName = [
    ["txt_username", "Username"],
    ["txt_password", "Password"],
    ["txt_password2", "Password2"],
    ["txt_firstname", "ชื่อจริง"],
    ["txt_firstname", "ชื่อจริง"],
    ["txt_lastname", "นามสกุล"],
    ["txt_idCard", "เลขประจำตัวประชาชน"],
    ["txt_nickname", "ชื่อเล่น"],
    ["date_birthday", "วันเกิด"],
    ["txt_idStd", "รหัสนักศึกษา"],
    ["txt_tel", "เบอร์โทรศัพท์"],
    ["txt_email", "อีเมลล์"],
    ["txt_home_number", "บ้านเลขที่"],
    ["txt_swine", "หมู่ที่"],
    ["txt_locality", "ตำบล"],
    ["txt_district", "อำเภอ"],
    ["txt_province", "จังหวัด"],
    ["txt_zipCode", "รหัสไปรษณี"],
    ["txt_stdEduAcademy", "จบการศึกษาจาก"],
    ["txt_stdEduComple", "ปีการศึกษาที่จบ"],
    ["txt_howmuch", "จำนวนเงินที่ได้รับอุปการะ"],
    ["txt_firstnameParents1", "ชื่อจริงบิดา"],
    ["txt_lastnameParents1", "นามสกุลบิดา"],
    ["txt_telParents1", "เบอร์ติดต่อบิดา"],
    ["txt_careerParents1", "อาชีพงานบิดา"],
    ["txt_workAtParents1", "สถานที่ทำงานบิดา"],
    ["txt_firstnameParents2", "ชื่อจริงมารดา"],
    ["txt_lastnameParents2", "นามสกุลมารดา"],
    ["txt_telParents2", "เบอร์ติดต่อมารดา"],
    ["txt_careerParents2", "อาชีพงานมารดา"],
    ["txt_workAtParents2", "สถานที่ทำงานมารดา"],
    ["txt_telParents2", "เบอร์ติดต่อมารดา"],
    ["txt_careerParents2", "อาชีพงานมารดา"],
    ["txt_workAtParents2", "สถานที่ทำงานมารดา"],
    ["select_blood_type", "เลือกหมู่เลือด"],
    ["select_religion", "เลือกศาสนา"],
    ["select_faculty", "เลือกคณะ"],
    ["select_branch", "เลือกสาขา"],
    ["select_stdEduDegree", "เลือกระดับชั้นศึกษา"],
    // Don't check ---------------------------------
    ["txt_firstnameEmergency1", "ชื่อจริงผู้ติดต่อฉุกเฉิน 1"],
    ["txt_lastnameEmergency1", "นามสกุลผู้ติดต่อฉุกเฉิน 1"],
    ["txt_telEmergency1", "เบอร์ติดต่อฉุกเฉิน 1"],
    ["txt_firstnameEmergency2", "ชื่อจริงผู้ติดต่อฉุกเฉิน 2"],
    ["txt_lastnameEmergency2", "นามสกุลผู้ติดต่อฉุกเฉิน 2"],
    ["txt_telEmergency2", "เบอร์ติดต่อฉุกเฉิน 2"],
    ["txt_swine", "หมู่ที่"],
    ["txt_alley", "ซอย"],
    ["txt_road", "ถนน"]
];


function checkEmpty() {
    var statusEmpty = true;
    var statusQcPassword = true;
    var msgShow = "\tคุณยังไม่ได้ให้ข้อมูลดังนี้<br>";

    for (let i = 0; i < inputName.length - 9; i++) {
        switch (document.forms["form_register"][inputName[i][0]].value.length) {
            case 0:
                statusEmpty = false;
                if (i < inputName.length) msgShow += "  " + inputName[i][1] + "  , ";
        }
    }

    msgShow = msgShow.slice(0, -3);

    if (document.forms["form_register"]["txt_password"].value == document.forms["form_register"]["txt_password2"].value &&
        document.forms["form_register"]["txt_password"].value.length >= 8) {
        document.getElementsByClassName('txtPass')[0].style.backgroundColor = "#fff";
        document.getElementsByClassName('txtPass')[1].style.backgroundColor = "#fff";
        statusQcPassword = true;
    } else {
        statusQcPassword = false;
        document.getElementsByClassName('txtPass')[0].style.backgroundColor = "#ffcccc";
        document.getElementsByClassName('txtPass')[1].style.backgroundColor = "#ffcccc";
        setInterval(() => {
            if (document.forms["form_register"]["txt_password"].value == document.forms["form_register"]["txt_password2"].value &&
                document.forms["form_register"]["txt_password"].value.length >= 8) {
                document.getElementsByClassName('txtPass')[0].style.backgroundColor = "#fff";
                document.getElementsByClassName('txtPass')[1].style.backgroundColor = "#fff";
                statusQcPassword = true;
            } else {
                statusQcPassword = false;
                document.getElementsByClassName('txtPass')[0].style.backgroundColor = "#ffcccc";
                document.getElementsByClassName('txtPass')[1].style.backgroundColor = "#ffcccc";
            }
        }, 1000);
    }

    if (!statusEmpty) {
        Swal.fire({
            title: 'คุณยังกรอกข้อมูลไม่ครบ',
            html: msgShow,
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ปิด'
        })
    } else if (!statusQcPassword) {
        Swal.fire({
            title: 'รหัสผ่านไม่ตรงกัน',
            text: 'หรืออาจน้อยกว่า 8 ตัว โปรดตรวจสอบรหัสของคุณอีกครั้ง',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ปิด'
        })
    }
    else popupForRegister();
}


function popupForRegister() {
    Swal.fire({
        title: 'คุณต้องการสมัครสมาชิกใช่หรือไม่',
        text: 'โปรดตรวจสอบข้อมูลให้ถูกต้องก่อนทำการสมัครสมาชิก',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันการสมัครสมาชิก',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hiddenBtnRegister').click();
        }
    })
}

function resetData() {
    Swal.fire({
        title: 'คุณต้องสมัครล้างข้อมูลใช่หรือไม่',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            for (let i = 0; i < inputName.length; i++) {
                document.forms["form_register"][inputName[i][0]].value = null;
            }
        }
    })
}


function useDataAfter(status) {

    switch (status) {
        case 1:
            let checkbox1 = document.getElementById('useDataAfter1');
            let f_fname = document.forms["form_register"]["txt_firstnameParents1"].value;
            let f_lname = document.forms["form_register"]["txt_lastnameParents1"].value;
            let f_tel = document.forms["form_register"]["txt_telParents1"].value;

            if (checkbox1.checked == true) {
                document.forms["form_register"]["txt_firstnameEmergency1"].value = f_fname;
                document.forms["form_register"]["txt_lastnameEmergency1"].value = f_lname;
                document.forms["form_register"]["txt_telEmergency1"].value = f_tel;
            } else {
                document.forms["form_register"]["txt_firstnameEmergency1"].value = null;
                document.forms["form_register"]["txt_lastnameEmergency1"].value = null;
                document.forms["form_register"]["txt_telEmergency1"].value = null;
            }
            break;
        case 2:
            let checkbox2 = document.getElementById('useDataAfter2');
            let m_fname = document.forms["form_register"]["txt_firstnameParents2"].value;
            let m_lname = document.forms["form_register"]["txt_lastnameParents2"].value;
            let m_tel = document.forms["form_register"]["txt_telParents2"].value;

            if (checkbox2.checked == true) {
                document.forms["form_register"]["txt_firstnameEmergency2"].value = m_fname;
                document.forms["form_register"]["txt_lastnameEmergency2"].value = m_lname;
                document.forms["form_register"]["txt_telEmergency2"].value = m_tel;
            } else {
                document.forms["form_register"]["txt_firstnameEmergency2"].value = null;
                document.forms["form_register"]["txt_lastnameEmergency2"].value = null;
                document.forms["form_register"]["txt_telEmergency2"].value = null;
            }
            break;
    }
}

function checkStatusFamily() {
    if (document.forms["form_register"]["select_statusParents1"].value == 0 && document.forms["form_register"]["select_statusParents2"].value == 0) {
        document.getElementsByClassName('EmergencyArea')[0].classList.remove('deactive');
        document.getElementsByClassName('EmergencyArea')[1].classList.remove('deactive');
    } else {
        document.getElementsByClassName('EmergencyArea')[0].classList.add('deactive');
        document.getElementsByClassName('EmergencyArea')[1].classList.add('deactive');
    }
}