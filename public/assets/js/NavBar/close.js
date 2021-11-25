let boutton_nav_bar = document.querySelector('button.navbar-toggler');
let menuCollapse = document.querySelector('#navbarNavDropdown');
console.log( boutton_nav_bar.ariaExpanded);
console.log(menuCollapse.style);
boutton_nav_bar.addEventListener('click', function(e) {

    if (boutton_nav_bar.ariaExpanded == 'true') {
        boutton_nav_bar.ariaExpanded == 'false';
        console.log('dans le if' + boutton_nav_bar.ariaExpanded);
    }
    
    /*if(menuCollapse.style.display == 'block') {
        console.log("je suis dans if");
        menuCollapse.style.display == 'none';
    }else {
        menuCollapse.style.display == 'none'
    }
    console.log(menuCollapse.style.display);*/
})