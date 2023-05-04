const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

const btnPopup = document.querySelector('.btnLogin');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', ()=> {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-popup');
});

particlesJS.load('particles-container', 'res/particles.js-master/demo/particles.json');

// ---------------------------------------- LOGIN ---------------------------------------- //

// const loginForm = document.getElementById('login-form');

// loginForm.addEventListener('submit', async (event) => {
//     event.preventDefault();

//     const formData = new FormData(loginForm);
//     const response = await fetch('/login', {
//         method: 'POST',
//         body: formData,
//     });

//     const json = await response.json();
//     if (json.success) {
//         console.log('Login successful!');
//         // window.location.href = '/admin/dash';
//     } else {
//         console.log('Login failed:', json.message);
//     }
// });

  