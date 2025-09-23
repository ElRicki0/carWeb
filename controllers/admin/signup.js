const SIGNUP_FORM = document.getElementById('signupForm');

document.addEventListener('DOMContentLoaded', async ()=> {
    MAIN_TITLE.textContent = 'Signup'
    loadTemplate();

    // check database to verify if exist any other admin user or if the  session is started
    const DATA = await fetchData(USER_API, 'readUsers');
    if (DATA.session) {
        location.href = 'dashboard.html';
        console.log('ERROR CODE #1')
    } else if (DATA.status) {
        location.href = 'index.html'
        console.log('ERROR CODE #2')
    }else{
        console.log('ERROR CODE#3')
    }
});

SIGNUP_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();

    const FORM = new FormData(SIGNUP_FORM);

    const DATA = await fetchData(USER_API, 'signUp', FORM);
    if (DATA.status) {
        sweetAlert(1, DATA.message, 'index.html');
    } else {
        sweetAlert(2, DATA.error);
    }
});