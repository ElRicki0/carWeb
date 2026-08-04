/*
* Controlador de uso general en las páginas web del sitio publico.
* Sirve para manejar la plantilla del encabezado y pie del documento.
*/


// Constante para completar la ruta de la API.
const USER_API = "services/public/user.php";
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Web Car - Dashboard';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/* Función asíncrona para cargar el encabezado y pie del documento.
* Parámetros: ninguno.
* Retorno: ninguno.
*/

const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <!-- Contenido de la barra de navegación -->
                    <nav class="navbar bg-body-tertiary fixed-top">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="inicio.html">Car sales website</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#contentMenu"
                                aria-controls="contentMenu" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="contentMenu"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h3 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="inicio.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Inicio</button>
                                            </a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="bodega.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Bodega</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="herramientas.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Herramientas</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="empleados.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Empleados</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="duplas.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Duplas</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="requisiciones.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Requisiciones</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="pedidos_herramientas.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Pedidos herramientas</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="consumibles.html">
                                                <button type="button" class="btn btn-outline-dark w-100">Consumibles</button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page">
                                                <button type="button" class="btn btn-danger w-100" onclick="logOut()">
                                                    Cerrar sesión
                                                </button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="perfil.html">
                                                <button type="button" class="btn btn-info w-100">
                                                    <i class="bi bi-person-circle"></i> Perfil
                                                </button>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </header>`);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', ``);
        } else {
            sweetAlert(3, DATA.error, 'index.html');
        }
    } else {

    }
};