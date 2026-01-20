window.onload = () => {


    // Lògica de Cerca i Filtres
    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            console.log("Buscant text:", e.target.value);
            // Aquí filtraries la teva llista d'usuaris per Nom o Cognom
        });
    }

    if (filterSelect) {
        filterSelect.addEventListener('change', (e) => {
            console.log("Canvi de filtre a:", e.target.value);
            // Aquí aplicaries el filtre per Curs o Població
        });
    }
};