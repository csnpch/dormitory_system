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

function callDateRange(status) {
    
    switch (status) {
        case 0:
            var date_range = document.getElementsByClassName('txt_timeRange')[0].value.split(' - ')[1].split('/');
            break;
        case 1:
            var date_range = document.getElementsByClassName('txt_timeRange')[0].value.split(' - ')[0].split('/');
            break;
    }

    nowTime = new Date();
    let hour = 24-(nowTime.getHours());
    let min = 60-(nowTime.getMinutes());
    let sec = 60-(nowTime.getSeconds());
    
    let day = ((parseInt(date_range[0]) - parseInt(nowTime.getDate())));
    let totalDay = 0; 

    let monthStart = nowTime.getMonth();
    let yearStart = nowTime.getFullYear();
    let controlLoop = 0;


    if (parseInt(date_range[1])-parseInt(nowTime.getMonth()) < 0) {
        controlLoop = ((parseInt(nowTime.getMonth() - parseInt(date_range[1]))) - parseInt(date_range[1]));
        if (parseInt(yearStart) < parseInt(date_range[2])) {
            controlLoop += parseInt(date_range[2]);
            controlLoop--;
        }
        controlLoop--;
        ++totalDay;
    } else {
        controlLoop = parseInt(date_range[1]) - parseInt(nowTime.getMonth());
    }
    
    for (let i = 1; i < controlLoop; i++) {
        totalDay += checkDate(monthStart, yearStart);

        monthStart++;
        if (monthStart > 12) {
            monthStart = 1;
            yearStart++;
        }
    }

    day = (totalDay - (checkDate(date_range[1]) - parseInt(date_range[0])) );
    day++;
    if (day > 99) {
        day = 99;
    }

    // let day = 0;
    // let hour = 0;
    // let min = 0;
    // let sec = 0;
    changeTimeCount('day', day);
    changeTimeCount('hour', hour);
    changeTimeCount('min', min);
    
    const clockCount = setInterval(() => {
    
        changeTimeCount('sec', --sec);

        if (day <= 0 && hour <= 0 && min <= 0 && sec < 1) {
            clearInterval(clockCount);
            changeTimeCount('day', 0);
            console.log('SYSTEM IS OPEN !!');
            setTimeout(() => {
                document.getElementById('changeStatusCustom').click();
            }, 1000);
        }

        if (sec <= 0) {
            sec = 60;
            if (min > 0 ) {
                changeTimeCount('min', --min);
            }
        }

        if (hour > 0 && min == 0) {
            min = 60;
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

