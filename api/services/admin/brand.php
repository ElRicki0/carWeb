<?php
require_once('../../models/data/data_brand.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $brand = new BrandData();

    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null, 'fileStatus' => null);

    if (isset($_SESSION['idAdministrator'])) {

        switch ($_GET['action']) {

            case 'createRow':
                // echo($_POST['nameBrand']);
                // die();
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setCategory2($_POST['categoryBrand2']) or
                    !$brand->setCategory3($_POST['categoryBrand3']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'])
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully created';
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while creating a brand';
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
