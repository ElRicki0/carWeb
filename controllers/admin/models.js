// ? api path
const BRAND_API = 'services/admin/brand.php';
const MODEL_API = 'services/admin/model.php';
// ? search form const
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_MODEL = document.getElementById('contentModels'),
    ROWS_FOUND = document.getElementById("rowsFound");
// ? modal content
const SAVE_MODAL = new bootstrap.Modal("#saveModal"),
    MODAL_TITLE = document.getElementById('modalTitle');
// ? picture image
const PICTURE_BRAND = document.getElementById('pictureBrand');
// ? form components
const SAVE_FORM = document.getElementById('saveForm'),
    ID_MODEL = document.getElementById('idModel'),
    NAME_MODEL = document.getElementById('nameModel'),
    BRAND_MODEL = document.getElementById('brandModel');
// ? type table const
let TABLE_TYPE = 1;

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Brands Models';
    fillTable(null, TABLE_TYPE);
});

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();

    (ID_MODEL.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);

    const DATA = await fetchData(MODEL_API, action, FORM);
    if (DATA.status) {
        SAVE_MODAL.hide();
        fillTable(null, TABLE_TYPE);
        sweetAlert(1, DATA.message)
    } else {
        sweetAlert(2, DATA.error)
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

const openCreate = () => {
    SAVE_MODAL.show();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Add new brand model';
    fillSelect(BRAND_API, 'readAll', 'brandModel');
};

const changeTableType = (value) => {
    if (value == 1 || value == 2) {
        TABLE_TYPE = value;
        fillTable(null, TABLE_TYPE);
        console.log('el valor de la tabla es el: ' + TABLE_TYPE);
        return TABLE_TYPE;
    } else {
        fillTable(null, TABLE_TYPE);
    }
}

const fillTable = async (form = null, TABLE_TYPE) => {
    CONTENT_MODEL.innerHTML = '';
    ROWS_FOUND.textContent = '';

    form ? (action = 'searchRows') : (action = 'readAll');
    const DATA = await fetchData(MODEL_API, action, form);
    if (DATA.status) {
        if (TABLE_TYPE == '1') {
            CONTENT_MODEL.innerHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-light align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Model name</th>
                            <th>Brand name</th>
                            <th>Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">

                    </tbody>
                </table>
            </div>
            `;
            TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                TABLE_BODY.innerHTML += `
            <tr class="table-light">
                <td>${row.name_model}</td>
                <td>${row.name_brand}</td>
                <td><img src="${SERVER_URL}images/brand/${row.picture_brand}" alt="Picture error" class="img-fluid" style="width: 200px"></td>
                <td><button type="button" class="btn btn-warning m-1" onClick="openUpdate(${row.id_model})"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-danger m-1" onClick="openDelete(${row.id_model})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
            });
        } else if (TABLE_TYPE == '2') {
            CONTENT_MODEL.innerHTML = `
            <div class="row justify-content-center" id="tableBody">
            </div>
            `;
            console.log('die end here');
            TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                TABLE_BODY.innerHTML+=`
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                    <div class="card w-100 d-flex flex-column">
                        <div class="d-flex justify-content-center align-items-center p-3">
                            <img src="${SERVER_URL}images/brand/${row.picture_brand}" class="img-fluid rounded border border-primary" alt="Picture Error" style="max-height:200px; width: auto;">
                        </div>
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">${row.name_model}</h5>
                                <p class="card-text">${row.name_brand}</p>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" onClick="openUpdate(${row.id_model})"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger" onClick="openDelete(${row.id_model})"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`
                ;
            })
        }
        ROWS_FOUND.textContent = DATA.message;

    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
}

const openUpdate = async(id) =>{
    const RESPONSE = await confirmAction('Do you want to update the model information?');
    if (RESPONSE.isConfirmed) {
        const FORM = new FormData();
        FORM.append('idModel', id);
        const DATA = await fetchData(MODEL_API, 'readOne', FORM);
        if (DATA.status) {
            SAVE_MODAL.show();
            MODAL_TITLE.textContent='Update information';
            SAVE_FORM.reset();

            const ROW = DATA.dataset;
            ID_MODEL.value = ROW.id_model;
            NAME_MODEL.value= ROW.name_model;
            fillSelect(BRAND_API, 'readAll', 'brandModel', parseInt(ROW.id_brand));

        } else {
        sweetAlert(2, DATA.error);
        }
    }
}

const openDelete = async(id)=>{
    const RESPONSE = await confirmAction('Do you want to delete the model information?');
    if (RESPONSE.isConfirmed) {
        const FORM = new FormData();
        FORM.append('idModel', id);
        const DATA = await fetchData(MODEL_API, 'deleteRow', FORM);
        if (DATA.status) {
            sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
}