// global js

// active link bottom menu
const list = document.querySelectorAll('.nav-bottom-list');

function activeLink(){
    list.forEach((item) =>
    item.classList.remove('nav-active'));
    this.classList.add('nav-active');
    }
list.forEach((item) => 
item.addEventListener('click',activeLink));


// hide notification
const notifications = document.querySelectorAll('.notification-manager .notification');

setTimeout(() => {
    for(const notification of notifications){
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}, 5000);

for(const notification of notifications){
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    })
}