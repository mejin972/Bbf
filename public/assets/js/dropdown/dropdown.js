console.log('log file dropdown js');

let dropdown = document.querySelector('#navbarDropdownMenuLink');
let dropdownMenu = document.querySelector('ul.dropdown-menu');
dropdownMenu.style.display = 'none';
console.log(dropdown);
console.log(dropdownMenu);

dropdown.addEventListener('click',function show() {
    console.log('je clik ' + dropdownMenu.style.display);
    if (dropdownMenu.style.display === 'none') {
        console.log('je rentre dans le if dropdown menu etait non visible');
        dropdownMenu.style.display = 'block';
        console.log('now: ' + dropdownMenu.style.display);
    }else{
        console.log('je suis dans le else' + dropdownMenu.style.display);
        dropdownMenu.style.display = 'none';
        console.log('son état maintenant ' + dropdownMenu.style.display);
    }
    
})