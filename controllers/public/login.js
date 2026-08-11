const LOGIN_FORM = document.getElementById('loginForm'),
    WRONG_USER_INFO = document.getElementById('wrongUserInfo');

document.getElementById('DOMContentLoaded', async () => {
    WRONG_USER_INFO.textContent = '';
    loadTemplate();

});

LOGIN_FORM.addEventListener('submit', async (event) => {

    event.preventDefault();

    const FORM = new FormData(LOGIN_FORM);

    const DATA = await fetchData(USER_API, 'logIn', FORM);

    if (DATA.status) {
        WRONG_USER_INFO.textContent = '';
        sweetAlert(1, DATA.message, 'dashboard.html');
    } else {
        sweetAlert(2, DATA.error);
        WRONG_USER_INFO.textContent = 'Invalid username or password';

    }
});