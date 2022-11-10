const button = document.querySelector('[expanse-collapse]');
const navbar = document.querySelector('.navbar');
const icon = document.getElementById('expanse-collapse-icon');

let expansed = false;

button.addEventListener('click', () => {
    if (expansed) {
        navbar.classList.add('short-navbar');
        navbar.classList.remove('long-navbar');
        icon.style.transform = "";
        expansed = false;
    } else {
        navbar.classList.remove('short-navbar');
        navbar.classList.add('long-navbar');
        icon.style.transform = "rotate(180deg)";
        expansed = true;
    }
})