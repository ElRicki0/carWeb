<?php
// Se incluye la clase del modelo.
require_once('../../models/data/data_category.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $category = new CategoriesData();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrator'])) {
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $category->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                // echo($_POST['statusCategory']);
                // die();
                if (
                    !$category->setName($_POST['nameCategory']) or
                    !$category->setDescription($_POST['descriptionCategory']) or
                    !$category->setType($_POST['typeCategory']) or
                    !$category->setStatus($_POST['statusCategory']) or
                    !$category->setPicture($_FILES['inputPictureCategory'])
                ) {
                    $result['error'] = $category->getDataError();

                } elseif ($category->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Category successfully created';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureCategory'], $category::PICTURE_PATH);
                } else {
                    $result['error'] = 'A problem occurred while registering the category';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $category->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . ' records found';
                } else {
                    $result['error'] = 'Currently there are no records';
                }
                break;
            case 'readOne':
                if (!$category->setId($_POST['idCategory'])) {
                    $result['error'] = $category->getDataError();
                } elseif ($result['dataset'] = $category->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Error to read the category';
                }
                break;
            case 'updateRow':
                if (
                    !$category->setId($_POST['idCategory']) or
                    !$category->setName($_POST['nameCategory']) or
                    !$category->setDescription($_POST['descriptionCategory']) or
                    !$category->setType($_POST['typeCategory']) or
                    !$category->setStatus($_POST['statusCategory']) or
                    !$category->setPicture($_FILES['inputPictureCategory'])
                ) {
                    $result['error'] = $category->getDataError();
                } else if ($category->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Category successfully updated';
                    $result['fileStatus'] = Validator::changeFile($_FILES['inputPictureCategory'], $category::PICTURE_PATH, $category->getFilename());
                } else {
                    $result['error'] = 'A problem occurred while updating the category';
                }
                break;
            case 'deleteRow':
                if (!$category->setId($_POST['idCategory'])) {
                    $result['error'] = $category->getDataError();
                } elseif ($category->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Category deleted successfully';
                    $result['fileStatus'] = Validator::deleteFile($category::PICTURE_PATH, $category->getFilename());
                } else {
                    $result['error'] = 'A problem occurred while deleting the category';
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
