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