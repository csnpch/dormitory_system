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


function callDateRange(status, value_date_range_old) {
    // let date_range_old = document.getElementsByClassName('txt_timeRange')[0].value.split(' - ')[(status == 0 ? 1 : 0)].split('/');
    let date_range = value_date_range_old.split(' - ')[(parseInt(status) == 0 ? 1 : 0)];

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
    
    changeTimeCount('day', day);
    changeTimeCount('hour', hour);
    changeTimeCount('min', min);
    
    clockCount = setInterval(() => {
    
        changeTimeCount('sec', --sec);

        if (day <= 0 && hour <= 0 && min <= 0 && sec < 1) {
            clearInterval(clockCount);
            changeTimeCount('day', 0);
            setTimeout(() => {
                if (status == 0) {
                    document.getElementById('changeStatusCustom').click();
                } else if (status == 1) {
                    document.getElementById('btn_auto_change_status2').click();
                }
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


window.onload = () => {
    setTimeout(() => {
        window.location.reload();
    }, 1200000);
};