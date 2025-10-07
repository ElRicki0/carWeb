// ? apis path
const CATEGORY_API = 'services/admin/category.php'
const BRAND_API = 'services/admin/brand.php'
// ? search form const
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_CATEGORIES = document.getElementById('contentCategories'),
    ROWS_FOUND = document.getElementById("rowsFound");
// ? modal content
const SAVE_MODAL = new bootstrap.Modal("#saveModal"),
    MODAL_TITLE = document.getElementById('modalTitle'),
    MODAL_BUTTON = document.getElementById('buttonModal');
// ? form components
const SAVE_FORM = document.getElementById('saveForm'),
    ID_BRAND = document.getElementById('idBrand'),
    NAME_BRAND = document.getElementById('nameBrand'),
    DESCRIPTION_BRAND = document.getElementById('descriptionBrand'),
    CATEGORY1_BRAND = document.getElementById('categoryBrand1'),
    CATEGORY2_BRAND = document.getElementById('categoryBrand2'),
    CATEGORY3_BRAND = document.getElementById('categoryBrand3');

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = "Car brands";
});

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    (ID_BRAND.value) ? action = 'updateRow' : action = 'createRow';
    const FORM = new FormData(SAVE_FORM);
    const DATA = await fetchData(BRAND_API, action, FORM);
    if (DATA.status) {
        SAVE_MODAL.hide();
        sweetAlert(1, DATA.message);
    } else {
        sweetAlert(2, DATA.error);
        console.log('ERROR #001');
    }
});

const openCreate = () => {
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Add new brand';
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand1');
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand2');
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand3');
};