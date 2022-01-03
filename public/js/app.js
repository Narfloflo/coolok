// global js

const list = document.querySelectorAll('.nav-bottom-list');

function activeLink(){
    list.forEach((item) =>
    item.classList.remove('nav-active'));
    this.classList.add('nav-active');
    }
list.forEach((item) => 
item.addEventListener('click',activeLink));


