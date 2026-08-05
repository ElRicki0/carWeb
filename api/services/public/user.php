<?php
// se incluye la case modelo
require_once('../../api/models/data/data_user.php');

// se comprueba si existe una acción realizar
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $user = new UserData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como usuario, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_GET['status'])) {
        // switch ($variable) {
        //     case 'value':
        //         # code...
        //         break;

        //     default:
        //         # code...
        //         break;
        // }
    } else {
        //? se realiza una acción cuando el usuario no tiene la sesión iniciada
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$user->setUsername($_POST['usernameUser']) or
                    !$user->setEmail($_POST['emailUser']) or
                    !$user->setPicture($_POST['pictureUser']) or
                    !$user->setPhone($_POST['phoneUser']) or
                    !$user->setName($_POST['nameUser']) or
                    !$user->setMiddlename($_POST['middlenameUser']) or
                    !$user->setLastname($_POST['lastnameUser']) or
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
            default:
                $result['error'] = 'Action not available outside the session';
                break;
        }
    }
} else {
    print(json_encode('Recurso no disponible'));
}
