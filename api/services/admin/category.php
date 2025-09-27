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
            case 'createRow':
                $_POST = Validator::validateForm($_POST);

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
                    $result['fileStatus'] = Validator::saveFile($_FILES['inputPictureCategory'], $category::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'A problem occurred while registering the category';
                }
                break;

            default:
                $result['error'] = 'Action not available inside the session';
                break;
        }
    } else {
        print (json_encode('Acceso denegado'));
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
