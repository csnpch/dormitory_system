function select_menu(select) {
    document.getElementsByClassName('menuBtn')[select].classList.remove('text-gray-300')
    document.getElementsByClassName('menuBtn')[select].classList.add('bg-gray-700')
}