// ? apis path
const BRAND_API = 'services/admin/brand.php'
// ? search form const
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_BRANDS = document.getElementById('contentBrands'),
    ROWS_FOUND = document.getElementById("rowsFound");
// ? modal content
const SAVE_MODAL = new bootstrap.Modal("#saveModal"),
    MODAL_TITLE = document.getElementById('modalTitle'),
    MODAL_BUTTON = document.getElementById('buttonModal');
// ? picture image
const PICTURE_BRAND = document.getElementById('pictureBrand');
// ? form components
const SAVE_FORM = document.getElementById('saveForm'),
    ID_BRAND = document.getElementById('idBrand'),
    NAME_BRAND = document.getElementById('nameBrand'),
    STATUS_BRAND1 = document.getElementById('statusBrand'),
    STATUS_BRAND2 = document.getElementById('statusBrand2'),
    DESCRIPTION_BRAND = document.getElementById('descriptionBrand'),
    INPUT_PICTURE_BRAND = document.getElementById('inputPictureBrand');
// ? type table const
let TABLE_TYPE = 1;

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = "Car brands";
    fillTable(null, TABLE_TYPE);
});

const setDefaultImg = () => {
PICTURE_BRAND.src ='./../../resources/img/error/404Picture.png';
};

// ? función para mostrar la imagen del input en una etiqueta image
INPUT_PICTURE_BRAND.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto FileReader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leído la imagen seleccionada se nos devuelve un objeto de tipo blob
        // Con el método createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            PICTURE_BRAND.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
});

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    (ID_BRAND.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);

    const DATA = await fetchData(BRAND_API, action, FORM);
    if (DATA.status) {
        console.log('ERROR #002');
        SAVE_MODAL.hide();
        sweetAlert(1, DATA.message);
        fillTable(null, TABLE_TYPE);

    } else {
        sweetAlert(2, DATA.error);
        console.log('ERROR #0069');
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
    setDefaultImg();
    SAVE_MODAL.show();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Add new brand';
};

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
    CONTENT_BRANDS.innerHTML = '';
    ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");

    const DATA = await fetchData(BRAND_API, action, form);
    if (DATA.status) {
        if (TABLE_TYPE == 1) {
            CONTENT_BRANDS.innerHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-light align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Brand picture</th>
                            <th>Brand name</th>
                            <th>Brand Description</th>
                            <th>status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">

                    </tbody>
                </table>
            </div>`;
            const TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_brand == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i> Visible'
                } else if (row.status_brand == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i> No visible'
                }

                TABLE_BODY.innerHTML += `
            <tr class="table-light">
                <td><img src="${SERVER_URL}images/brand/${row.picture_brand}" alt="Picture error" class="img-fluid" style="height: 200px"></td>
                <td>${row.name_brand}</td>
                <td>${row.description_brand}</td>
                <td>${visualization}</td>
                <td><button type="button" class="btn btn-warning m-1" onClick="openUpdate(${row.id_brand})"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-danger m-1" onClick="openDelete(${row.id_brand})"><i class="bi bi-trash"></i></button>
                    <button type="button" class="btn btn-info m-1" onClick="openState(${row.id_brand})">${visualization}</button></td>
            </tr>
            `;
            });
        } else if (TABLE_TYPE == 2) {
            // Usar una fila centrada y columnas responsivas de Bootstrap
            CONTENT_BRANDS.innerHTML = `
            <div class="row justify-content-center" id="tableBody">
            </div>
            `;
            TABLE_BODY = document.getElementById("tableBody");
            DATA.dataset.forEach(row => {
                if (row.status_brand == 1) {
                    visualization = '<i class="bi bi-eye-fill"></i> Visible'
                } else if (row.status_brand == 0) {
                    visualization = '<i class="bi bi-eye-slash-fill"></i> No visible'
                }

                TABLE_BODY.innerHTML += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="card w-100 d-flex flex-column">
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <img src="${SERVER_URL}images/brand/${row.picture_brand}" class="img-fluid rounded border border-primary" alt="Picture Error" style="max-height:200px;">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">${row.name_brand}</h5>
                            <p class="card-text">${row.description_brand}</p>
                        </div>
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
};

const openUpdate = async (id) => {
    setDefaultImg();
    const FORM = new FormData();
    FORM.append('idBrand', id);
    const DATA = await fetchData(BRAND_API, 'readOne', FORM);
    if (DATA.status) {
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Update information';
        SAVE_FORM.reset();
        const ROW = DATA.dataset;
        ID_BRAND.value = ROW.id_brand;
        NAME_BRAND.value = ROW.name_brand;
        DESCRIPTION_BRAND.value = ROW.description_brand;
        PICTURE_BRAND.src = './../../api/images/brand/'+ROW.picture_brand;
        PICTURE_BRAND.onerror = () => {
        PICTURE_BRAND.src = './../../resources/img/error/404Picture.png';
    };
        if (ROW.status_brand == 1) {
            STATUS_BRAND1.checked = true;
            STATUS_BRAND2.checked = false;
        } else if (ROW.status_brand == 0) {
            STATUS_BRAND1.checked = false;
            STATUS_BRAND2.checked = true;
        }
    } else {
        sweetAlert(2, DATA.error);
    }
};

const openDelete = async (id) => {
    setDefaultImg();
    const RESPONSE = await confirmAction('Do you want to delete this record?');
    if (RESPONSE.isConfirmed) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idBrand', id);
        const DATA = await fetchData(BRAND_API, 'deleteRow', FORM);
        if (DATA.status) {
            sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
};

const openState = async (id) => {
    const RESPONSE = await confirmAction('Do you want to change the record visibility?');
    if (RESPONSE.isConfirmed) {
        const FORM = new FormData();
        FORM.append('idBrand', id);
        const DATA = await fetchData(BRAND_API, 'changeStatus', FORM);
        if (DATA.status) {
            sweetAlert(1, DATA.message);
            fillTable(null, TABLE_TYPE);
        } else {
            sweetAlert(2, DATA.error);
        }
    }
};