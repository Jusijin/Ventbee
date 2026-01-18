document.addEventListener('DOMContentLoaded', function () {
const toggle = document.getElementById('togglepassword');
const password = document.getElementById('password');

if (toggle && password) {
    toggle.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
    });
}
});