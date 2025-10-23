<?php
require_once('../../models/data/data_car.php');

if (isset($_GET['action'])) {

    session_start();

    $car = new CarData();

    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);

    if (isset($_SESSION['idAdministrator'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $car->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;

            default:
                $result['error'] = 'Action not available inside the session';
                break;
        }
    } else {
        print (json_encode('Access denied'));
    }

    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print (json_encode($result));
} else {
    print (json_encode('Recurso no disponible'));
}
