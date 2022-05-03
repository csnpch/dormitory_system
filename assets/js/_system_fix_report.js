function changeColorStatus(n, status) {
    setTimeout(() => {
        switch(status) {
            case 0: document.getElementsByClassName('txtStatus')[n].classList.add('text-green-600');
                break;
            case 1: document.getElementsByClassName('txtStatus')[n].classList.add('text-red-500');
                break;
            case 2: document.getElementsByClassName('txtStatus')[n].classList.add('text-red-800');
        }
    }, 100);
}

console.log('hi');