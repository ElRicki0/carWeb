// ? api constants
const CATEGORIES_API = "services/admin/category.php";
// ? Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_CATEGORIES = document.getElementById('contentCategories'),
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
    DESCRIPTION_CATEGORY = document.getElementById('descriptionCategory'),
    STATUS_CATEGORY = document.getElementById('statusCategory'),
    STATUS_CATEGORY2 = document.getElementById('statusCategory2');
// ? tipe table const
let TABLE_TYPE = 1;

document.addEventListener("DOMContentLoaded", () => {
    loadTemplate();
    MAIN_TITLE.textContent = "Categories";
    fillTable(null, TABLE_TYPE);
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

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    (ID_CATEGORY.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);

    const DATA = await fetchData(CATEGORIES_API, action, FORM);

    if (DATA.status) {
        SAVE_MODAL.hide();
        fillTable(null, TABLE_TYPE);
        sweetAlert(1, DATA.message);
    } else {
        sweetAlert(2, DATA.error);
        console.log('ERROR #001');
    }
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM, TABLE_TYPE);
});

const changeTableType = (value) => {
    if (value === 1 || value === 2) {
        TABLE_TYPE = value;
        fillTable(null, TABLE_TYPE);
        console.log('el valor de la tabla es el: ' + TABLE_TYPE);
        return TABLE_TYPE;
    } else {
        fillTable(null, TABLE_TYPE);
        console.log('el valor de la tabla es el: ' + TABLE_TYPE);
    }
};

const fillTable = async (form = null, TABLE_TYPE) => {
    CONTENT_CATEGORIES.innerHTML = '';
    ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");

    const DATA = await fetchData(CATEGORIES_API, action, form);

    if (DATA.status) {
        if (TABLE_TYPE == 1) {
            CONTENT_CATEGORIES.innerHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-light align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Category name</th>
                            <th>Category Description</th>
                            <th>Category Type</th>
                            <th>Status</th>
                            <th>Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">

                    </tbody>
                </table>
            </div>`;
            const TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_category == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i>'
                } else if (row.status_category == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i>'
                }
                TABLE_BODY.innerHTML += `
            <tr class="table-light">
                <td>${row.name_category}</td>
                <td>${row.description_category}</td>
                <td>${row.usage_type_category}</td>
                <td>${visualization}</td>
                <td><img src="${SERVER_URL}images/category/${row.picture_category}" alt="Picture error" class="img-fluid" style="width: 200px"></td>
                <td><button type="button" class="btn btn-warning" onClick="openUpdate(${row.id_category})"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-danger" onClick="openDelete(${row.id_category})"><i class="bi bi-trash"></i></button>
                    <button type="button" class="btn btn-info" onClick="openUpdate(${row.id_category})">${visualization}</button></td>
            </tr>
            `;
            });
        } else if (TABLE_TYPE == 2) {
            // Usar una fila centrada y columnas responsivas de Bootstrap
            CONTENT_CATEGORIES.innerHTML = `
            <div class="row justify-content-center" id="tableBody">
            </div>
            `;
            TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_category == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i>'
                } else if (row.status_category == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i>'
                }
                TABLE_BODY.innerHTML += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="card w-100 d-flex flex-column">
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <img src="${SERVER_URL}images/category/${row.picture_category}" class="img-fluid rounded border border-primary" alt="Picture Error" style="max-height:200px; width: auto;">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">${row.name_category}</h5>
                            <p class="card-text">${row.description_category}</p>
                        </div>
                        <div>
                            <p class="card-text"><small class="text-muted">Estado: ${visualization}</small></p>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning" onClick="openUpdate(${row.id_category})"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger" onClick="openDelete(${row.id_category})"><i class="bi bi-trash"></i></button>
                            <button type="button" class="btn btn-info" onClick="openUpdate(${row.id_category})"> ${visualization}</button>
                        </div>
                    </div>
                </div>
            </div>
            `;
            });
        }
        ROWS_FOUND.textContent = DATA.message;
    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
};

const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = "Crear categoría";
    // Se prepara el formulario.
    SAVE_FORM.reset();
};

const openUpdate = async (id) => {
    const FORM = new FormData();
    FORM.append('idCategory', id);

    const DATA = await fetchData(CATEGORIES_API, 'readOne', FORM);
    if (DATA.status) {
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Update information';
        SAVE_FORM.reset();
        const ROW = DATA.dataset;
        ID_CATEGORY.value = ROW.id_category;
        NAME_CATEGORY.value = ROW.name_category;
        DESCRIPTION_CATEGORY.value = ROW.description_category;
        TYPE_CATEGORY.value = ROW.usage_type_category;
        if (ROW.status_category == 1) {
            STATUS_CATEGORY.checked = true;
            STATUS_CATEGORY2.checked = false;
        } else {
            STATUS_CATEGORY.checked = false;
            STATUS_CATEGORY2.checked = true;
        }
    } else {
        sweetAlert(2, DATA.error);
    }
};

const openDelete = async (id) => {
    const RESPONSE = await confirmAction('Do you want to delete this record?');
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idCategory', id);
        const DATA = await fetchData(CATEGORIES_API, 'deleteRow', FORM);
        if (DATA.status) {
            await sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
};