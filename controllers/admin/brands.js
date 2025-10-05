// ? apis path
const CATEGORY_API = 'services/admin/category.php'
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


const openCreate = () => {
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Add new brand';
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand1');
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand2');
    fillSelect(CATEGORY_API, 'readAll', 'categoryBrand3');
};