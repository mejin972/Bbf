console.log(" fichier name_adress.js");

let declencheur = document.querySelectorAll('button.btn.btn-danger');
let modal = document.querySelector('div.modal-body');
let modalText;
let insertion = document.querySelectorAll('span.insert');
//console.log(modalText);
let titleAdress;

declencheur.forEach(element => {
    element.addEventListener("click", handlerEvent);

});


function handlerEvent(e) {
    element_parent = e.target.parentNode;
    titleAdress = element_parent.firstChild.nextElementSibling.innerText;
    insertion.forEach(element => {
        element.innerText = titleAdress;
    });
    //insertion.innerText = titleAdress;
    //console.log(element_parent.firstChild.nextElementSibling);
}