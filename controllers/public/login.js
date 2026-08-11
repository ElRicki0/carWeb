LOGIN_FORM = document.getElementById('loginForm');

document.getElementById('DOMContentLoaded', async () => {

    loadTemplate();

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