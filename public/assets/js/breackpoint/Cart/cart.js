/*let refBreack = document.querySelector('body');
let breackPoint = getBreackPoint();
let iconQuantity = document.querySelectorAll('.icon_manage_quantity');
console.log(iconQuantity);
let htmlQuantity = document.querySelectorAll('.up_to_mobile_L');
console.log(htmlQuantity);
let newHtmlQuantity = document.querySelectorAll('select.mobile_L');
console.log(newHtmlQuantity);

console.log(breackPoint);

let ssb = document.querySelectorAll('.ssb');
console.log('le id du produit: ' + ssb.length); 


function getBreackPoint() {
    return  window.getComputedStyle(refBreack, '::before').content.replace(/\"/g, '');
}
if (breackPoint == 'mobile_L') {
    changeBreakPoint(breackPoint);
}
window.addEventListener('resize', function () {
    console.log("  le breack d'origine: " +getBreackPoint());
    breackPoint = getBreackPoint();
    console.log('Après le rezise: '+breackPoint);
    changeBreakPoint(breackPoint);
}, false);

function changeBreakPoint(breackPoint){
    console.log("je suis dans la fonction change breack " + breackPoint);
    switch (breackPoint) {
        case 'mobile_L':
            let id =[];
            let tr = document.querySelectorAll('tbody tr');
            console.log(tr);
            let selectParent;
            let ssbParent;
            let parent;
            let parentOfParent;
            let nbProduct = document.querySelectorAll('span.nb_js');
            console.log(nbProduct);
            let nb;
            
            //if (newHtmlQuantity.style.display == 'block') {
                newHtmlQuantity.forEach(element => {
                    if (breackPoint == 'mobile_L') {
                        let key = [];
                        let choix ;
                        if (key.length <= 0) { 
                            for (let index = 1; index < 51; index++) {
                                key.push(index) ;
                                choix = key.pop()
                                let option =  new Option(choix, choix);
                                element.appendChild(option) 
                            }
                        }
                        console.log( element.options);
                        let value = element.options[element.selectedIndex].value;
                        console.log( "base valeur " + value );
                        
                        selectParent = element.parentNode;

                        /*nbProduct.forEach(elementNbProduct => {
                            console.log(elementNbProduct.parentNode);
                            parent = elementNbProduct.parentNode;
                            parentOfParent = parent.parentNode;
                            console.log( parentOfParent );
                           if (parentOfParent ==  selectParent) {
                            nb = elementNbProduct.innerHTML;
                            let reSelect = element.selectedIndex = nb-1;
                            console.log( element);
                            console.log(nb);
                            reSelect = nb ;
                            console.log( reSelect  );
                           }
                        });*/

                      /*ssb.forEach(elementSsb=>{
                            ssbParent=element.parentNode;
                            if (ssbParent == selectParent) {
                                console.log("ils ont le meme parent");
                                console.log(elementSsb);
                               
                               
                            }
                        });
                        
                        let newValue;
                        let oldValue;
                        
                        
                        element.addEventListener('change',function(){
                            oldValue = value;
                            newValue = element.options[element.selectedIndex].value;
                            value = newValue;
                            console.log( "new valeur apres event onChange: " + newValue); 
                            console.log( "old valeur apres event onChange: " + oldValue);
                            selectParent = element.parentNode;
                            ssb.forEach(element => {
                                console.log(element.parentNode);
                                console.log(element);
                                ssbParent=element.parentNode;
                                if (ssbParent == selectParent) {
                                    console.log("ils ont le meme parent");
                                    console.log(element);
                                    id = element.innerHTML;
                                    
                                }
                                console.log(id);
                                let refSend = newValue - nb;
                                console.log(refSend);
                               
                                //window.location.href = "http://127.0.0.1:8000/cart/add/"+ id;
                                var route = "{{ path('add_to_cart', {'id': "+id+" })|escape('js') }}";
                            });
                            nbProduct.forEach(elementNbProduct => {
                                console.log(elementNbProduct.parentNode);
                                parent = elementNbProduct.parentNode;
                                parentOfParent = parent.parentNode;
                                console.log( parentOfParent );
                               if (parentOfParent ==  selectParent) {
                                nb = elementNbProduct.innerHTML;
                                let reSelect = element.selectedIndex = nb-1;
                                console.log( element);
                                console.log(nb);
                                reSelect = nb ;
                                console.log( reSelect  );
                               }
                            });
                            //window.location.href = "http://127.0.0.1:8000/cart/add/"+ id;
                        },false);
                        
                        console.log( element.selectedIndex);
                        
                        

                        if (tr.length == ssb.length) {
                            console.log(tr.length);
                            console.log(ssb.length);
                            let test = 0;
                            while (test < 4) {
                                test++;
                                console.log(ssb[0].innerHTML);
                            }
                            
                        }
                        console.log(element);
                        console.log(ssb);  
                            
                    }
                });
                

            //}
            break;
        case 'none':
            iconQuantity.forEach(element => {
                //console.log(element);
                element.style.display = 'block';
            });
            htmlQuantity.forEach(element => { 
                
                element.style.display = 'block';
                
            });
            break;
    
        default:
            break;
    }

    
   
}*/

let trTable = document.querySelectorAll('table.table tbody tr');
let keyTr;
//console.log(trTable);
let selects = document.querySelectorAll('select');
let optionSelectioner = document.querySelectorAll('span.up_to_mobile_L span.nb_js');
let opt; 
let id;
let checkLoop = null;

selects.forEach(element => {
    //opt = element.options[element.selectedIndex].value;
    if (checkLoop == null) {
        checkLoop = 0;
    }else {
        checkLoop++;
    }
    console.log(checkLoop);
    element.addEventListener('change',function(e){
        //console.log(e.currentTarget.options.selectedIndex);
        let linkAdd = document.querySelectorAll('span.link a');
        opt = element.options[element.selectedIndex].value;
        selection = element.options[element.selectedIndex];
        id = selection.getAttribute('product');
        //console.log(selection);
        //console.log(id);
        //console.log(opt);
        for (let index = 0; index < linkAdd.length; index++) {
            const lien = linkAdd[index];
            if (lien.offsetParent.childNodes[5].isSameNode(e.currentTarget)) {
                //console.log("c'est le meme select ");
                lien.href = "/cart/add/"+ id +"/"+opt;
            }
        }
        
    },false);
    //console.log(optionSelectioner[checkLoop].innerHTML-1);
    element.selectedIndex = optionSelectioner[checkLoop].innerHTML-1;
});



let link = document.querySelectorAll('span.link');
let path ='<a href= "{{path('+'add_to_cart'+',{'+ 'id'+ ': product.product.id,'+  'quantity'+ ':'+ '"+ '+opt+' +"} )}} class="icon_manage_quantity" title="augmenter quantité">"' ;
let test ;
let textTest;

let checkLoop2 = null;
link.forEach(element => {
    if (checkLoop2 == null) {
        checkLoop2 = 0;
    }else{
        checkLoop2++;
    }
    opt = selects[checkLoop2].options[selects[checkLoop2].selectedIndex].value;
    test = document.createElement("a");
    textTest = document.createTextNode("Modifier quantité");
    test.appendChild(textTest);
    if (opt == null) {
        opt = 1;
        //test.href = "{{path('add_to_cart', {'id': "+ id +", 'quantity' : "+ opt +"})|escape('js')}}";
        test.href = "/cart/add/"+ id +"/"+opt;
    }else{

        test.href = "/cart/add/"+ id +"/"+opt;
    }
    element.appendChild(test);
    //console.log(element);
});

//console.log(link);
