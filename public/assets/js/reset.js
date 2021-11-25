console.log("je suis dans le js");

let notification = document.querySelector(".alert.alert-danger");
let newPassword = document.querySelector("#newPassword");
let comfirmNewPassword = document.querySelector("#confirmNewPassword");
let bouttonSend = document.querySelector("form button");

console.log(notification);
console.log(newPassword);
console.log(comfirmNewPassword);
console.log("le boutton submit", bouttonSend);

bouttonSend.addEventListener("click", function(e) {
    //console.log("je click, mais le prevent default empeche le post");
    check();
   
});



function check(){

    if(newPassword.value === comfirmNewPassword.value){
        console.log("les deux input sont égaux");
        notification.className = "alert alert-success";
        /*
            Une approche légère pour insérer des chaînes dans une page consiste à utiliser les méthodes de manipulation DOM natives : document.createElement, Element.setAttribute, et Node.textContent.
            L'approche sécurisée consiste à créer les nœuds séparément et à affecter leur contenu à l'aide de textContent :

            https://developer.mozilla.org/fr/docs/Mozilla/Add-ons/WebExtensions/Safely_inserting_external_content_into_a_page
            
        */
            notification.textContent = "La procédure c'est bien passer, vous aller recevoir un e-mail de comfirmation dans quelque instant.";
    }else{
        console.log("ils sont différent");
        notification.style.visibility = "visible";
        notification.textContent = "Votre nouveau mot de passe et sa comfirmation ne sont pas identique.";
        e.preventDefault();
    }
}