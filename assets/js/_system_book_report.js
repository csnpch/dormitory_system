var checkClick = true;
function report() {
    getLocalStorage();

    let btn = document.getElementById('btn_report');
    btn.value = "เพิ่มข้อมูลในเอกสารและพิมพ์อีกครั้ง";

    if (checkClick) {
        checkClick = false;
        setInterval(() => {
            btn.classList.remove('scale-100');
            btn.classList.add('scale-105');
            setTimeout(() => {
                btn.classList.remove('scale-105');
                btn.classList.add('scale-100');
            }, 1000);
        }, 2000)
    }
    onPopup()
}

function onPopup() {
    document.getElementById('areaDataAppend').classList.remove('hidden');
    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('overlay').classList.remove('deactive');
}

function closePopup() {
    document.getElementById('areaDataAppend').classList.add('hidden');
    document.getElementById('overlay').classList.add('hidden');
}



document.getElementById('btn_appendData').addEventListener('click', () => {
    closePopup();
});


document.addEventListener('keydown', function(e) {
    if(e.keyCode == 27){
        closePopup();
    }
});

function is_disease() {
    switch(document.getElementById('select_disease').value) {
        case '0':
            document.forms["dataAppend"]["txt_disease"].value = "";
            document.getElementsByClassName('is_disease')[0].classList.add('hidden');
            document.getElementsByClassName('is_disease')[1].classList.add('hidden');
            break;
        case '1': 
            document.getElementsByClassName('is_disease')[0].classList.remove('hidden');
            document.getElementsByClassName('is_disease')[1].classList.remove('hidden');
    }
}



var status_book = null;

function reportData() {
    if (status_book == null) {
        return false;
    } else {
        return true;    
    }
}

function setValueStatusBook(status_book) {
    this.status_book = status_book;
}

async function getData() {
    let checkData = setInterval(() => {
        if (!reportData()) {
            console.log('No data!');
        } else {
            pushDate();
            clearInterval(checkData);
        }
    }, 1000);
}


function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function datediff(first, second) {
    return (Math.round((second-first)/(1000*60*60*24)));
}


function pushDate() {
    // console.log(this.status_book);
    let nowTime = new Date();
    let day = (datediff(parseDate(nowTime.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }).split(',')[0]), parseDate(this.status_book.status_date_stop)));
    document.getElementById('5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833').value = day;
}

async function main() {
    await getData();
}


main();

function cancelBook() {
    Swal.fire({
        title: 'คุณต้องยกเลิกการจองห้องพัก ?',
        text: 'โปรดยืนยันการกระทำนี้อีกครั้ง',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390').click();
        }
    })
}