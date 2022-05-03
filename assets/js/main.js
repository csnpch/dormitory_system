function dateFormat(e) {
    return e.value.split('-')[2]+'/'+e.value.split('-')[1]+'/'+e.value.split('-')[0];
}

// Sleep
function Sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}