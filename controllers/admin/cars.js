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
const PICTURE_BRAND = document.getElementById('pictureBrand');
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

INPUT_PICTURE_CAR.addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function (event) {
            PICTURE_BRAND.src = event.target.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Cars management';
    fillTable(null, TABLE_TYPE);
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
    CONTENT_CAR.innerHTML = ''; ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");

    const DATA = await fetchData(CAR_API, action, form);
    if (DATA.status) {

    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
}

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

const openCreate = async () => {
    SAVE_MODAL.show();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Add new car';
    fillSelect(BRAND_API, 'readAll', 'brandCar');
}

BRAND_CAR.addEventListener('change', async () => {
    const brandId = BRAND_CAR.value;
    console.log('Marca seleccionada:', brandId);
    if (brandId && brandId !== 'null') {
        const FORM = new FormData();
        FORM.append('idBrand', brandId);
        fillSelect(MODEL_API, 'readByBrand', 'modelCar', FORM);
    } else {
        document.getElementById('modelCar').innerHTML = '<option selected>First select a brand</option>';
    }
});