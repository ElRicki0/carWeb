SIGNUP_FORM = document.getElementById('signupForm');

document.addEventListener('DOMContentLoaded', async ()=> {
    MAIN_TITLE.textContent='Signup'
    loadTemplate();
});

SIGNUP_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();

    const FORM = new FormData(SIGNUP_FORM);

    const DATA = await fetchData(USER_API, 'signUp', FORM);
    if (DATA.status) {
        sweetAlert(1, DATA.message, 'login.html');
    } else {
        sweetAlert(2, DATA.error);
    }
});