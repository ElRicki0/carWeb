// ? api constants
const CATEGORIES_API = "services/admin/category.php";
// ? table constants
const TABLE_BODY = document.getElementById("tableBody"),
    ROWS_FOUND = document.getElementById("rowsFound");
// ? modal content
const SAVE_MODAL = new bootstrap.Modal("#saveModal"),
    MODAL_TITLE = document.getElementById('modalTitle'),
    MODAL_BUTTON = document.getElementById('buttonModal');
// ? picture image
const PICTURE_CATEGORY = document.getElementById('pictureCategory');
// ? form components
const SAVE_FORM = document.getElementById('saveForm'),
    ID_CATEGORY = document.getElementById('idCategory'),
    INPUT_PICTURE_CATEGORY = document.getElementById('inputPictureCategory'),
    NAME_CATEGORY = document.getElementById('nameCategory'),
    TYPE_CATEGORY = document.getElementById('typeCategory'),
    DESCRIPTION_CATEGORY = document.getElementById('descriptionCategory');
    // STATUS_ACTIVE_CATEGORY = document.getElementById('statusActiveCategory'),
    // STATUS_INACTIVE_CATEGORY = document.getElementById('statusInactiveCategory'),
    // SERVER_STATUS_CATEGORY = document.getElementById('serverStatusCategory');

document.addEventListener("DOMContentLoaded", () => {
    loadTemplate();
    MAIN_TITLE.textContent = "Categories";
    // updateServerStatus();
});

// ? función para mostrar la imagen del input en una etiqueta image
INPUT_PICTURE_CATEGORY.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto FileReader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leído la imagen seleccionada se nos devuelve un objeto de tipo blob
        // Con el método createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            PICTURE_CATEGORY.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
});

// Función para actualizar el valor del checkbox oculto
// function updateServerStatus() {
//     if (STATUS_ACTIVE_CATEGORY.checked) {
//         SERVER_STATUS_CATEGORY.value = "1";
//     } else if (STATUS_INACTIVE_CATEGORY.checked) {
//         SERVER_STATUS_CATEGORY.value = "0";
//     }
// }

// Escuchar cambios en ambos radios
// STATUS_ACTIVE_CATEGORY.addEventListener('change', updateServerStatus);
// STATUS_INACTIVE_CATEGORY.addEventListener('change', updateServerStatus);


SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    (ID_CATEGORY.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);

    const DATA = await fetchData(CATEGORIES_API, action, FORM);

    if (DATA.status) {
        SAVE_MODAL.hide();
        sweetAlert(1, DATA.message);
    } else {
        sweetAlert(2, DATA.error);
        console.log('ERROR #001');
    }
});

const fillTable = async (form = null) => {
    TABLE_BODY.textContent = "";
    ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");
    const DATA = await fetchData(CATEGORIES_API, action, form);
    if (DATA) {
    } else {
    }
};

const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = "Crear categoría";
    // Se prepara el formulario.
    SAVE_FORM.reset();
};

const closeModal = () => {

};