<?php
require_once('../../models/data/data_car.php');

if (isset($_GET['action'])) {

    session_start();

    $car = new CarData();

    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);

    if (isset($_SESSION['idAdministrator'])) {
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $car->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$car->setModel($_POST['modelCar']) or
                    !$car->setColor($_POST['colorCar']) or
                    !$car->setYear($_POST['yearCar']) or
                    !$car->setStatus($_POST['statusCar']) or
                    !$car->setPicture($_FILES['inputPictureCar'])
                ) {
                    $result['error'] = $car->getDataError();
                } elseif ($car->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Car successfully created';
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureCar'], $car::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while creating the car';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $car->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'readOne':
                if (!$car->setId($_POST['idCar'])) {
                    $result['error'] = $car->getDataError();
                } elseif ($result['dataset'] = $car->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Error to read the record';
                }
                break;
            case 'deleteRow':
                if (!$car->setId($_POST['idCar'])) {
                    $result['error'] = $car->getDataError();
                } elseif ($car->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Car deleted successfully';
                    $result['fileStatus'] = Validator::deleteFile($car::PICTURE_PATH, $car->getFilename());
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (!$car->setId($_POST['idCar'])) {
                    $result['error'] = $car->getDataError();
                } else {
                    // Obtener el nombre actual de la imagen
                    $oldFileData = $car->readFileName();
                    $oldFileName = $oldFileData['picture_car'] ?? null;
                    $hasNewImage = !empty($_FILES['inputPictureCar']['tmp_name']);
                    if (
                        !$car->setModel($_POST['modelCar']) or
                        !$car->setColor($_POST['colorCar']) or
                        !$car->setYear($_POST['yearCar']) or
                        !$car->setStatus($_POST['statusCar']) or
                        !$car->setPicture($_FILES['inputPictureCar'], $oldFileName)
                    ) {
                        $result['error'] = $car->getDataError();
                    } elseif ($car->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Car successfully update';
                    } else {
                        $result['error'] = 'A problem occurred while updating a brand';
                    }
                }
                break;
            case 'changeStatus':
                if (!$car->setId($_POST['idCar'])) {
                    $result['error'] = $car->getDataError();
                } elseif ($car->changeStatus()) {
                    $result['status'] = 1;
                    $result['message'] = 'Car visibility successfully changed';
                } else {
                    $result['error'] = 'A problem occurred while changing the car visibility';
                }

                break;
            default:
                $result['error'] = 'Action not available inside the session';
                break;
        }
    } else {
        print(json_encode('Access denied'));
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
