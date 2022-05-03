dataSave = {
    "bed_male":         0,
    "bed_female":       0,
    "bed_use_male":     0,
    "bed_use_female":   0,
    "totals_person":    0,
    "totals_male":      0,
    "totals_female1":   0,
    "totals_female2":   0,
}

var strData = [
    ['bed_male'],
    ['bed_female'],
    ['bed_use_male'],
    ['bed_use_female'],
    ['totals_person'],
    ['totals_male'],
    ['totals_female1'],
    ['totals_female2']
];

async function setData(n, value) {
    await pushText(n, value);
    await setAppendDataLocal(n, value);
    await getDataSave();
    console.log('Php working!!');
}

async function pushText(n, value) {
    document.getElementsByClassName('pullData')[n].innerText = value;   
    dataSave[strData[n]] = value;
}

async function setAppendDataLocal() {
    let dataAppend_serilized = JSON.stringify(dataSave);
    localStorage.setItem("dataSave", dataAppend_serilized);
}

async function getDataSave() {
    let dataAppend_serilized = JSON.parse(localStorage.getItem("dataSave"));
    
    for (let i = 0; i < strData.length; i++) {
        try { 
            document.getElementsByClassName('pullData')[i].innerText = dataAppend_serilized[strData[i]].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");   
        } catch (error) { continue; }
    }
    console.log('Js working!!');
}

window.onload = setTimeout(() => {
    getDataSave();
}, 100);
