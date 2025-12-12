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
    fillTable();
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
})

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
            CONTENT_MODEL.innerHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-light align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Model name>
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
        }
    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
}
