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
    NAME_MODEL = document.getElementById('nameModel');
// ? brand modal content
const BRAND_MODAL = new bootstrap.Modal('#brandModal');
// ? type table const
let TABLE_TYPE = 1;

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Brands Models';
    fillTable();
});

const openCreate = () => {
    SAVE_MODAL.show();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Add new brand model';
    fillSelect(BRAND_API, 'readAll', 'brandModel');
};

const fillTable = async (form = null, TABLE_TYPE) => {
    CONTENT_MODEL.innerHTML = '';
    ROWS_FOUND.textContent = '';

    form ? (action = 'searchRow') : (action = 'readAll');
    const DATA = await fetchData(MODEL_API, action, form);
    if (DATA.status) {
        if (TABLE_TYPE == '1') {
        } else if (TABLE_TYPE == '2') {
        }
    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
}

const openBrand = ()=> {
    SAVE_MODAL.hide();
    BRAND_MODAL.show();
}