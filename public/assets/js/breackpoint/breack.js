let breakPoint;
let select = document.querySelector('form #categories');

var getBreakpoint = function () {
    
	return window.getComputedStyle(select, '::before').content.replace(/\"/g, '');
    
};

breakPoint = getBreakpoint();

window.addEventListener('resize', function () {
    console.log(' le get de breack '+getBreakpoint());
    breakPoint = getBreakpoint();
    console.log('Le breack '+breakPoint);
}, false);