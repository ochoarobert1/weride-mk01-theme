var menuBtn = '';
var menuCtr = '';
var menuSidebar = '';

/* CUSTOM ON LOAD FUNCTIONS */
function documentCustomLoad() {
    "use strict";
    console.log('Functions Correctly Loaded');

    menuBtn = document.getElementById('menuBtn');
    menuCtr = document.getElementById('menuMobile');
    menuBtn.addEventListener('click', function(e) {
        e.preventDefault;
        menuCtr.classList.toggle('header-menu-hidden');
    });
    menuSidebar = document.getElementById('sidebarBtn');
    menuSidebar.addEventListener('click', function(e) {
        document.getElementById('sidebar').classList.toggle('d-flex');
    });

}

document.addEventListener("DOMContentLoaded", documentCustomLoad, false);