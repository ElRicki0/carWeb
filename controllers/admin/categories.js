// ? api constants
const CATEGORIES_API = "services/admin/category.php";
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
    DESCRIPTION_CATEGORY = document.getElementById('descriptionCategory');
// ? tipe table const
const TABLE_TYPE = 1;

document.addEventListener("DOMContentLoaded", () => {
    loadTemplate();
    MAIN_TITLE.textContent = "Categories";
    fillTable(null, 1);
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
        sweetAlert(1, DATA.message);
    } else {
        sweetAlert(2, DATA.error);
        console.log('ERROR #001');
    }
});

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
                            <th>Category status</th>
                            <th>Picture</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">

                    </tbody>
                </table>
            </div>`;
            const TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                TABLE_BODY.innerHTML += `
            <tr class="table-light">
                <td>${row.name_category}</td>
                <td>${row.description_category}</td>
                <td>${row.usage_type_category}</td>
                <td>${row.status_category}</td>
                <td><img src="${SERVER_URL}images/category/${row.picture_category}" alt="Picture error" class="img-fluid" style="width: 200px"></td>
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
                            <p class="card-text"><small class="text-muted">Estado: ${row.status_category}</small></p>
                        </div>
                    </div>
                </div>
            </div>
            `;
            });
        }


        ROWS_FOUND.textContent = DATA.message;

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