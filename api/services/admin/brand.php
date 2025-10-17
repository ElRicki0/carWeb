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
            case 'createRow1':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'])
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->createRow1()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully created';
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while creating a brand';
                }
                break;
            case 'createRow2':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setCategory2($_POST['categoryBrand2']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'])
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->createRow2()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully created';
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while creating a brand';
                }
                break;
            case 'createRow3':
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
                } elseif ($brand->createRow3()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully created';
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while creating a brand';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $brand->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'readOne':
                if (!$brand->setId($_POST['idBrand'])) {
                    $result['error'] = $brand->getDataError();
                } elseif ($result['dataset'] = $brand->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Error to read the category';
                }
                break;
            case 'updateRow1':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setId($_POST['idBrand']) or
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'], $brand->readFileName())
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->updateRow3()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully update';
                    $result['fileStatus'] = Validator::changeFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH, $brand->readFileName());
                } else {
                    $result['error'] = 'A problem occurred while updating a brand';
                }
                break;
            case 'updateRow2':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setId($_POST['idBrand']) or
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setCategory2($_POST['categoryBrand2']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'], $brand->readFileName())
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->updateRow3()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully update';
                    $result['fileStatus'] = Validator::changeFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH, $brand->readFileName());
                } else {
                    $result['error'] = 'A problem occurred while updating a brand';
                }
                break;
            case 'updateRow3':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$brand->setId($_POST['idBrand']) or
                    !$brand->setName($_POST['nameBrand']) or
                    !$brand->setDescription($_POST['descriptionBrand']) or
                    !$brand->setStatus($_POST['statusBrand']) or
                    !$brand->setCategory1($_POST['categoryBrand1']) or
                    !$brand->setCategory2($_POST['categoryBrand2']) or
                    !$brand->setCategory3($_POST['categoryBrand3']) or
                    !$brand->setPicture($_FILES['inputPictureBrand'], $brand->readFileName())
                ) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->updateRow3()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand successfully update';
                    $result['fileStatus'] = Validator::changeFile($_FILES['inputPictureBrand'], $brand::PICTURE_PATH, $brand->readFileName());
                } else {
                    $result['error'] = 'A problem occurred while updating a brand';
                }
                break;
            case 'deleteRow':
                if (!$brand->setId($_POST['idBrand'])) {
                    $result['error'] = $brand->getDataError();
                } elseif ($brand->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Brand deleted successfully';
                    $result['fileStatus'] = Validator::deleteFile($brand::PICTURE_PATH, $brand->getFilename());
                } else {
                    $result['error'] = 'A problem occurred while deleting the brand';
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
