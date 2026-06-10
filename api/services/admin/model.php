<?php

use LDAP\Result;

require_once('../../models/data/data_model.php');

if ($_GET['action']) {

    session_start();

    $model = new DataModel();

    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null,);
    if (isset($_SESSION['idAdministrator'])) {
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $model->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$model->setName($_POST['nameModel']) or
                    !$model->setBrand($_POST['brandModel'])
                ) {
                    $result['error'] = $car->getDataError();
                } elseif ($model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Model brand successfully created';
                } else {
                    $result['error'] = 'A problem occurred while creating model brand';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'readOne':
                if (!$model->setId($_POST['idModel'])) {
                    $result['error'] = $model->getDataError();
                } elseif ($result['dataset'] = $model->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'readAllBrand':
                if (!$model->setId($_POST['idBrand'])) {
                    $result['error'] = $model->getDataError();
                } elseif ($result['dataset'] = $model->readAllBrand()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$model->setId($_POST['idModel']) or
                    !$model->setName($_POST['nameModel']) or
                    !$model->setBrand($_POST['brandModel'])
                ) {
                    $result['error'] = $model->getDataError();
                } elseif ($model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Model brand successfully updated';
                } else {
                    $result['error'] = 'A problem occurred while updating model brand';
                }
                break;
            case 'deleteRow':
                if (!$model->setId($_POST['idModel'])) {
                    $result['error'] = $model->getDataError();
                } elseif ($model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Model brand successfully deleted';
                } else {
                    $result['error'] = 'A problem occurred while deleting the model';
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
