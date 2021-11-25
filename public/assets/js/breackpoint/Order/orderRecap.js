let breackPoint;
let refBreack = document.querySelector('body');
let target = document.querySelectorAll('div.order_summary div.row');

var getBreakpoint = function () {
    
	return window.getComputedStyle(refBreack, '::before').content.replace(/\"/g, '');
    
};

breakPoint = getBreakpoint();
console.log(breakPoint);
if (breakPoint == 'tablette') {
    console.log(target);
    changeClassName(breakPoint);
}

window.addEventListener('resize', function () {
    //console.log(' avant prise en compte modif: '+ getBreakpoint());
    breakPoint = getBreakpoint();
    //console.log('apres la rezise de la page: '+breakPoint);
}, false);

function changeClassName(breakPoint) {
    if (breakPoint == 'tablette') {
        target.forEach(element => {
            element.className = 'container_order';
        });
    }
}