<?php
// Se incluye la clase del modelo.
require_once('../../models/data/data_administrator.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $administrator = new administratorData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrator'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['aliasAdministrator'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['aliasAdministrator'];
                } else {
                    $result['error'] = 'Correo de administrador indefinido';
                }
                break;
            default:
                $result['error'] = 'acción no disponible dentro de la session';
                break;
        }
    } else {
        //? se realiza una acción cuando el administrador no tiene la sesión iniciada
        switch ($_GET['action']) {
            case 'readUsers':
                if ($administrator->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'You must authenticate to log in';
                } else {
                    $result['error'] = 'You must create a new account';
                }
                break;
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrator->setName($_POST['nameAdmin']) or
                    !$administrator->setEmail($_POST['emailAdmin']) or
                    !$administrator->setPhone($_POST['phoneAdmin']) or
                    !$administrator->setUsername($_POST['usernameAdmin']) or
                    !$administrator->setPassword($_POST['passwordAdmin'])
                ) {
                    $result['error'] = $administrator->getDataError();
                } elseif ($_POST['passwordAdmin'] != $_POST['password2Admin']) {
                    $result['error'] = 'different passwords';
                } elseif ($administrator->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Administrator successfully registered';
                } else {
                    $result['error'] =  'A problem occurred while registering the administrator';
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
