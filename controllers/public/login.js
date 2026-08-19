const LOGIN_FORM = document.getElementById('loginForm'),
    WRONG_USER_INFO = document.getElementById('wrongUserInfo');

document.addEventListener('DOMContentLoaded', async () => {

    WRONG_USER_INFO.textContent = '';
    loadTemplate();

    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        location.href = 'index.html';
    } else {
        sweetAlert(4, DATA.error, 'logIn.html');
    }
});



LOGIN_FORM.addEventListener('submit', async (event) => {

    event.preventDefault();

    const FORM = new FormData(LOGIN_FORM);

    const DATA = await fetchData(USER_API, 'logIn', FORM);

    if (DATA.status) {
        WRONG_USER_INFO.textContent = '';
        sweetAlert(1, DATA.message, 'index.html');
    } else {
        sweetAlert(2, DATA.error);
        WRONG_USER_INFO.textContent = 'Invalid username or password';

    }
});