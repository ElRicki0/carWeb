<?php
// se incluye la case modelo
require_once('../../models/data/data_user.php');

// se comprueba si existe una acción realizar
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $user = new UserData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como usuario, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idUser'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usernameUser'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usernameUser'];
                } else {
                    $result['error'] = 'Invalid Username';
                }
                break;
            default:
                $result['error'] = 'Action not available inside the session';
                break;
        }
    } else {
        //? se realiza una acción cuando el usuario no tiene la sesión iniciada
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$user->setName($_POST['nameUser']) or
                    !$user->setMiddlename($_POST['middlenameUser']) or
                    !$user->setLastname($_POST['lastnameUser']) or
                    !$user->setEmail($_POST['emailUser']) or
                    !$user->setPhone($_POST['phoneUser']) or
                    !$user->setUsername($_POST['usernameUser']) or
                    !$user->setPassword($_POST['passwordUser'])
                ) {
                    $result['error'] = $user->getDataError();
                } elseif ($_POST['passwordUser'] != $_POST['password2User']) {
                    $result['error'] = 'different passwords';
                } elseif ($user->signUp()) {
                    $result['status'] = 1;
                    $result['message'] = 'User successfully registered';
                } else {
                    $result['error'] =  'A problem occurred while registering the user';
                }
                break;
            case 'logIn':
                $_POST = Validator::validateForm($_POST);
                if ($user->checkUser($_POST['usernameUser'], $_POST['passwordUser'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Login Successfully';
                } else {
                    $result['error'] = 'Invalid username or password';
                }
                break;
            default:
                $result['error'] = 'Action not available outside the session';
                break;
        }
    }
    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
