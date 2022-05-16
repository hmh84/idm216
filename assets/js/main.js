// Set top padding to header based on nav height

const nav = document.querySelector('nav');
const header = document.querySelector('header');

window.onresize = responsivenessCheck;
window.onload = initCheck;

function initCheck() {
    responsivenessCheck();
    window.scrollTo(0, 0);
}

function responsivenessCheck() {
    var x = nav.clientHeight;
    header.style.paddingTop = x+'px';
}

// Nav button
$(document).ready(function(){
    $(".menu-button").click(function(){
        $("#menu").slideToggle("slow");
    });
});