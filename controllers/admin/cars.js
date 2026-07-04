// ? api path
const CAR_API = 'services/admin/car.php';
const BRAND_API = 'services/admin/brand.php';
const MODEL_API = 'services/admin/model.php';
// ? search form const
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_CAR = document.getElementById('contentCars'),
    ROWS_FOUND = document.getElementById("rowsFound");
// ? modal content
const SAVE_MODAL = new bootstrap.Modal("#saveModal"),
    MODAL_TITLE = document.getElementById('modalTitle');
// ? picture image
const PICTURE_CAR = document.getElementById('pictureBrand');
// ? form components
const SAVE_FORM = document.getElementById('saveForm'),
    ID_CAR = document.getElementById('idCar'),
    MODEL_CAR = document.getElementById('modelCar'),
    COLOR_CAR = document.getElementById('colorCar'),
    YEAR_CAR = document.getElementById('yearCar'),
    STATUS_CAR = document.getElementById('statusCar'),
    STATUS_CAR2 = document.getElementById('statusCar2'),
    BRAND_CAR = document.getElementById('brandCar'),
    INPUT_PICTURE_CAR = document.getElementById('inputPictureCar');
// ? type table const
let TABLE_TYPE = 1;

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Cars management';
    fillTable(null, TABLE_TYPE);
});

const setDefaultImg = () => {
    PICTURE_CAR.src = './../../resources/img/error/404Picture.png';
};

INPUT_PICTURE_CAR.addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function (event) {
            PICTURE_CAR.src = event.target.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
});

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();

    (ID_CAR.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);
    const DATA = await fetchData(CAR_API, action, FORM);
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

const openCreate = async () => {
    setDefaultImg();
    SAVE_MODAL.show();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Add new car';
    fillSelect(BRAND_API, 'readAll', 'brandCar');
}

const loadModelsByBrand = async (brandId, selectedModelId = null) => {
    if (brandId && brandId !== 'null') {
        const FORM = new FormData();
        FORM.append('idBrand', brandId);
        await fillSelect(MODEL_API, 'readByBrand', 'modelCar', FORM);
        if (selectedModelId) {
            MODEL_CAR.value = selectedModelId;
        }
    } else {
        MODEL_CAR.innerHTML = '<option value="" selected>First select a brand</option>';
    }
};

BRAND_CAR.addEventListener('change', async () => {
    const brandId = BRAND_CAR.value;
    await loadModelsByBrand(brandId);
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
    CONTENT_CAR.innerHTML = '';
    ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");

    const DATA = await fetchData(CAR_API, action, form);
    if (DATA.status) {
        if (TABLE_TYPE == 1) {
            CONTENT_CAR.innerHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-light align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Car picture</th>
                            <th>Car brand</th>
                            <th>Car year</th>
                            <th>Car color</th>
                            <th>Visibility</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">

                    </tbody>
                </table>
            </div>`;
            const TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_car == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i> Visible'
                } else if (row.status_car == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i> No visible'
                }
                TABLE_BODY.innerHTML += `
            <tr class="table-light">
                <td><img src="${SERVER_URL}images/car/${row.picture_car}" alt="Picture error" class="img-fluid" style="height: 200px"></td>
                <td><img src="${SERVER_URL}images/brand/${row.picture_brand}" alt="Picture error" class="img-fluid" style="height: 200px"></td>
                <td> YEAR: ${row.year_car}</td>
                <td> COLOR: ${row.color_car}</td>
                <td>${visualization}</td>
                <td><button type="button" class="btn btn-warning m-1" onClick="openUpdate(${row.id_car})"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-danger m-1" onClick="openDelete(${row.id_car})"><i class="bi bi-trash"></i></button>
                    <button type="button" class="btn btn-info m-1" onClick="openState(${row.id_car})">${visualization}</button></td>
            </tr>
            `;
            });
        } else if (TABLE_TYPE == 2) {

            CONTENT_CAR.innerHTML = `
            <div class="row justify-content-center" id="tableBody">
            </div>`;

            TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_car == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i> Visible'
                } else if (row.status_car == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i> No visible'
                }
                TABLE_BODY.innerHTML += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="card w-100 d-flex flex-column">
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <img src="${SERVER_URL}images/car/${row.picture_car}" class="img-fluid rounded border border-primary" alt="Picture Error" style="max-height:200px;">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="card-text">${row.name_brand}</h4>
                            <h4 class="card-text">Model</h4>
                            <p class="card-text">${row.name_model}</p>
                            <h4 class="card-text">Year</h4>
                            <p class="card-text">${row.year_car}</p>
                        </div>
                        <div>
                            <p class="card-text text-center"><small class="text-muted">Estado: ${visualization}</small></p>
                        </div>

                        <div class="mt-3 d-flex justify-content-center gap-2 mb-2">
                            <button type="button" class="btn btn-warning" onClick="openUpdate(${row.id_brand})"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger" onClick="openDelete(${row.id_brand})"><i class="bi bi-trash"></i></button>
                            <button type="button" class="btn btn-info" onClick="openState(${row.id_brand})"> ${visualization}</button>
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
}

const openUpdate = async (id) => {
    setDefaultImg();
    const FORM = new FormData();
    FORM.append('idCar', id);
    const DATA = await fetchData(CAR_API, 'readOne', FORM);
    if (DATA.status) {
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Update car';
        SAVE_FORM.reset();
        const ROW = DATA.dataset;
        ID_CAR.value = ROW.id_car;
        COLOR_CAR.value = ROW.color_car;
        YEAR_CAR.value = ROW.year_car;
        PICTURE_CAR.src = SERVER_URL + 'images/car/' + ROW.picture_car;
        PICTURE_CAR.onerror = () => {
            PICTURE_CAR.src = './../../resources/img/error/404Picture.png';
        };

        await fillSelect(BRAND_API, 'readAll', 'brandCar');
        BRAND_CAR.value = ROW.id_brand;
        await loadModelsByBrand(ROW.id_brand, ROW.id_model);

        if (ROW.status_car == 1) {
            STATUS_CAR.checked = true;
            STATUS_CAR2.checked = false;
        } else if (ROW.status_car == 0) {
            STATUS_CAR.checked = false;
            STATUS_CAR2.checked = true;
        }
    } else {
        sweetAlert(2, DATA.error);
    }
}

const openState = async (id) => {
    const RESPONSE = await confirmAction('Do you want to change the visibility?');
    if (RESPONSE.isConfirmed) {
        const FORM = new FormData();
        FORM.append('idCar', id);
        const DATA = await fetchData(CAR_API, 'changeStatus', FORM);
        if (DATA.status) {
            sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
}

const openDelete = async (id) => {
    const RESPONSE = await confirmAction('Do you want to delete the this record?')
    if (RESPONSE.isConfirmed) {
        const FORM = new FormData();
        FORM.append('idCar', id);
        const DATA = await fetchData(CAR_API, 'deleteRow', FORM);
        if (DATA.status) {
            sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
}