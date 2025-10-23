// ? api path
const CAR_API = 'services/admin/car.php';
// ? search form const
const SEARCH_FORM = document.getElementById('searchForm');
// ? table constants
const CONTENT_CAR = document.getElementById('contentCars'),
    ROWS_FOUND = document.getElementById("rowsFound");

// ? type table const
let TABLE_TYPE = 1;

document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Cars management';
    fillTable(null, TABLE_TYPE);
});

const fillTable = async (form = null, TABLE_TYPE) => {
    CONTENT_CAR.innerHTML = '';
    ROWS_FOUND.textContent = "";

    form ? (action = "searchRows") : (action = "readAll");

    const DATA = await fetchData(CAR_API, action, form);
    if (DATA.status) {
        
    } else {
        ROWS_FOUND.textContent = DATA.error;
        sweetAlert(2, DATA.error);
    }
}