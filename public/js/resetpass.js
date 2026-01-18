document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('togglepassword');
  const password = document.getElementById('password');

  const toggleConfirm = document.getElementById('toggleconfirm');
  const confirmPassword = document.getElementById('password_confirm');

  toggle.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });

  toggleConfirm.addEventListener('click', function () {
    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPassword.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
});