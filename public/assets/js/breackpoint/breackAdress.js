let breakPoint;
let refBreack = document.querySelector('body');
let target = document.querySelector('.btn.btn-info.btn-sm.float-right');
let target2 = document.querySelector('.btn.btn-info.down')

var getBreakpoint = function () {
    
	return window.getComputedStyle(refBreack, '::before').content.replace(/\"/g, '');
    
};

breakPoint = getBreakpoint();
console.log(breakPoint);

changeClassName();


window.addEventListener('resize', function () {
    console.log(' avant prise en compte modif: '+ getBreakpoint());
    breakPoint = getBreakpoint();
    changeClassName();
    console.log('apres la rezise de la page: '+breakPoint);
}, false);

function changeClassName(){

    switch (breakPoint) {
        case 'phone':
            target.className = 'btn btn-info';
            target.style.display = 'block';
            target2.style.display = 'none';
            console.log('class du button ajouter une adresse: ' + target.className);
            break;
        case 'tablette':
            target.className = 'btn btn-info';
            target.style.display = 'block';
            target2.style.display = 'none';
            console.log('class du button ajouter une adresse: ' + target.className);
            break;
        case 'laptop':
            target.style.display = 'none';
            target2.style.display = 'block';
            console.log('display du button ajouter une adresse: ' + target.style.display);
            break;
        case 'laptop_L':
            target.style.display = 'none';
            target2.style.display = 'block';
            console.log('display du button ajouter une adresse: ' + target.style.display);
            break;
        case '4K':
            target.style.display = 'none';
            target2.style.display = 'block';
            console.log('display du button ajouter une adresse: ' + target.style.display);
            break;
        default:
            target.className = 'btn btn-info btn-sm float-right';
            console.log('class du button ajouter une adresse: ' + target.className);
            break;
    }
/*
    if ((breakPoint == 'phone') || (breakPoint == 'tablette')) {
        target.className = 'btn btn-info';
        console.log('class du button ajouter une adresse: ' + target.className);
    }
    
    
    if ((breakPoint != 'phone') || (breakPoint != 'tablette') && (target.className = 'btn btn-info')) {
        target.className = 'btn btn-info btn-sm float-right';
        console.log('class du button ajouter une adresse: ' + target.className);
    }*/
   
}