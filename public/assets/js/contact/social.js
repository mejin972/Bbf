let textMagic = document.querySelectorAll(".text_magic");
let img = document.querySelectorAll(".social_media img")
console.log(img[0]);

/*
img.forEach(element => {
    element.addEventListener("mouseenter",mouseEnter);
    element.addEventListener("mouseleave",mouseLeave);
    
});*/
//textMagic.style.transition = "all 2s";
for(i of img){
    (function(i){
        i.addEventListener("mouseenter",function(){
            if (i === img[0]) {
                textMagic[0].style.transitionTimingFunction = "ease-in";
                textMagic[0].style.transition = "2s";
                textMagic[0].style.opacity = "100";
                console.log(textMagic[0]);
            }
            if (i === img[1]) {
                textMagic[1].style.transitionTimingFunction = "ease-in";
                textMagic[1].style.transition = "2s";
                console.log(textMagic[1]);
                textMagic[1].style.opacity = "100"
            }
            if (i === img[2]) {
                textMagic[2].style.transitionTimingFunction = "ease-in";
                textMagic[2].style.transition = "2s";
                console.log(textMagic[2]);
                textMagic[2].style.opacity = "100"
            }
            
            
        });
        i.addEventListener("mouseleave",function(){
            if (i === img[0]) {
                textMagic[0].style.transitionTimingFunction = "ease-out";
                textMagic[0].style.transition = "2.5s";
                textMagic[0].style.opacity = "0";
                console.log(textMagic[0]);
            }
            if (i === img[1]) {
                textMagic[1].style.transitionTimingFunction = "ease-out";
                textMagic[1].style.transition = "2.5s";
                console.log(textMagic[1]);
                textMagic[1].style.opacity = "0"
            }
            if (i === img[2]) {
                textMagic[2].style.transitionTimingFunction = "ease-out";
                textMagic[2].style.transition = "2.5s";
                console.log(textMagic[2]);
                textMagic[2].style.opacity = "0"
            }
            
        });
    })(i);
}
/*
for (let index = 0; index < textMagic.length; index++) {
    const element = textMagic[index];
    element.style.opacity = "20";
    console.log(element);  
}*/
    

function mouseEnter(){
    console.log("je rentre");
}

function mouseLeave(){
    
    console.log("je sors");
}
