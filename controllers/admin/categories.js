// ? api constants
const CATEGORIES_API = 'api/services/admin/categories.php'
// ? table constants
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');


document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    MAIN_TITLE.textContent = 'Categories';
});

const fillTable = async (form = null) => {
    TABLE_BODY.textContent = '';
    ROWS_FOUND.textContent = '';

    (form) ? action = 'searchRows' : action = 'readAll';
    const DATA = await fetchData(CATEGORIES_API, action, form);
    if (DATA) {
        
    } else {
        
    }
};