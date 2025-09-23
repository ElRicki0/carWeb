const LOGIN_FORM = document.getElementById("loginForm");

document.addEventListener('DOMContentLoaded', async () => {

    loadTemplate();

    const DATA = await fetchData(USER_API, 'readUsers');
    if (DATA.session) {
        location.href = 'dashboard.html';
    } else if (DATA.status) {
        MAIN_TITLE.textContent = 'Log In Administrador';
        sweetAlert(4, DATA.message);
    } else {
        sweetAlert(4, DATA.error, 'signup.html');
    }
});

LOGIN_FORM.addEventListener('submit', async (event) => {

    event.preventDefault();

    const FORM = new FormData(LOGIN_FORM);

    const DATA = await fetchData(USER_API, 'logIn', FORM);

    if (DATA.status) {
        sweetAlert(1, DATA.message, 'dashboard.html');
    } else {
        sweetAlert(2, DATA.error);
    }
});