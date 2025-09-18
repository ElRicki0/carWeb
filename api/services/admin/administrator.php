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
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null, 'type' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrator'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
        }
    } else {
        //? se realiza una acción cuando el administrador no tiene la sesión iniciada
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrator->setName($_POST['nombreAdmin']) or
                    !$administrator->setEmail($_POST['correoAdmin']) or
                    !$administrator->setUsername($_POST['aliasAdmin']) or
                    !$administrator->setPassword($_POST['password']) or
                    !$administrator->setPicture($_FILES['imagenAdmin'])
                ) {
                    $result['error'] = $administrator->getDataError();
                } elseif ($_POST['password'] != $_POST['password2']) {
                    $result['error'] = 'different passwords';
                } elseif ($administrator->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Administrator successfully registered';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenAdmin'], $administrator::PICTURE_PATH);
                } else {
                    $result['error'] =  'A problem occurred while registering the administrator';
                }
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
