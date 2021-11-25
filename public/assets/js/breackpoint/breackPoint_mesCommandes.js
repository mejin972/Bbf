let breakPoint;
let select = document.querySelector('body');
let target = document.querySelectorAll('#accordionExample button.btn.btn-primary');
console.log(select);
let refAction = document.querySelector('button.accordion-button');
console.log(refAction.className);


var getBreakpoint = function () {
    
	return window.getComputedStyle(select, '::before').content.replace(/\"/g, '');
    
};

breakPoint = getBreakpoint();

window.addEventListener('resize', function () {
    console.log(' le get de breack '+getBreakpoint());
    breakPoint = getBreakpoint();
    
    console.log('Le breack '+breakPoint);
}, false);
/*
document.getElementById("myDiv").style.margin = "50px 0px 0px 0px";
                                                top right buttom left
*/
refAction.addEventListener('click', function () {
    addStyle();
   
})
function addStyle(){
    console.log(target);
    if ((refAction.getAttribute('aria-expanded') == 'true') && (breakPoint == 'mobile_L') ){
        target[0].style.margin = '0px 0px 10px 0px';
    }
}

