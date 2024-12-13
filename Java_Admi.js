// Función para habilitar el campo Código
function enableCodeField() {
    document.getElementById("searchCode").disabled = false;  // Habilita el campo Código
    document.getElementById("searchRazonSocial").disabled = true;  // Deshabilita el campo Razón Social
    document.getElementById("searchNumber").disabled = true;  // Deshabilita el campo Número
}

// Función para habilitar el campo Razón Social
function enableRazonSocialField() {
    document.getElementById("searchRazonSocial").disabled = false;  // Habilita el campo Razón Social
    document.getElementById("searchCode").disabled = true;  // Deshabilita el campo Código
    document.getElementById("searchNumber").disabled = true;  // Deshabilita el campo Número
}

// Función para habilitar la casilla de búsqueda de Número o Nombre
function enableSearchField(type) {
    const searchField = document.getElementById("searchNumber");
    searchField.disabled = false;
    
    if (type === 'number') {
        searchField.placeholder = 'Número';  // Cambia el nombre del campo a "Número"
    } else if (type === 'name') {
        searchField.placeholder = 'Nombre';  // Cambia el nombre del campo a "Nombre"
    }
}

// Función para deshabilitar el campo Número y su valor
function disableSearchField() {
    const searchField = document.getElementById("searchNumber");
    searchField.disabled = true;
    searchField.value = '';  // Limpia el campo de texto
}

// Función para habilitar los campos de fecha
function enableDateFields() {
    document.getElementById("startDate").disabled = false;  // Habilita el campo de fecha de inicio
    document.getElementById("endDate").disabled = false;    // Habilita el campo de fecha de fin
    document.getElementById("startDate").focus();           // Focaliza el campo de fecha de inicio
}

// Función para deshabilitar los campos de fecha
function disableDateFields() {
    document.getElementById("startDate").disabled = true;   // Deshabilita el campo de fecha de inicio
    document.getElementById("endDate").disabled = true;     // Deshabilita el campo de fecha de fin
    document.getElementById("startDate").value = '';        // Limpia el valor del campo de fecha de inicio
    document.getElementById("endDate").value = '';          // Limpia el valor del campo de fecha de fin
}

// Función para aplicar los filtros
function applyFilters() {
    const filters = {
        code: document.getElementById("searchCode").value.toLowerCase(),
        razonSocial: document.getElementById("searchRazonSocial").value.toLowerCase(),
        number: document.getElementById("searchNumber").value.toLowerCase(),
        name: document.getElementById("searchName").value.toLowerCase(),
        orderStatus: document.querySelector('input[name="orderStatus"]:checked')?.value || 'all',
        startDate: document.getElementById("startDate").value,
        endDate: document.getElementById("endDate").value
    };

    const rows = document.querySelectorAll("#dataTable .dataRow");

    rows.forEach(row => {
        const rowData = {
            code: row.querySelector(".codigo")?.textContent.toLowerCase() || "",
            razonSocial: row.querySelector(".razon_social")?.textContent.toLowerCase() || "",
            number: row.querySelector(".numero")?.textContent.toLowerCase() || "",
            name: row.querySelector(".nombre")?.textContent.toLowerCase() || "",
            estado: row.querySelector(".estado")?.textContent.toLowerCase() || "",
            fecha: row.querySelector(".fecha")?.textContent || ""
        };

        const matches = {
            code: filters.code === "" || rowData.code.includes(filters.code),
            razonSocial: filters.razonSocial === "" || rowData.razonSocial.includes(filters.razonSocial),
            number: filters.number === "" || rowData.number.includes(filters.number),
            name: filters.name === "" || rowData.name.includes(filters.name),
            orderStatus: filters.orderStatus === "all" || rowData.estado.includes(filters.orderStatus),
            dateRange: (!filters.startDate || new Date(rowData.fecha) >= new Date(filters.startDate)) &&
                        (!filters.endDate || new Date(rowData.fecha) <= new Date(filters.endDate))
        };

        row.style.display = Object.values(matches).every(Boolean) ? "" : "none";
    });
}

// Función para habilitar los campos cuando se selecciona "Todos"
function enableAllFields() {
    document.getElementById("searchCode").disabled = true;  // Deshabilita el campo Código
    document.getElementById("searchRazonSocial").disabled = true;  // Deshabilita el campo Razón Social
    document.getElementById("searchNumber").disabled = true;  // Deshabilita el campo Número
    document.getElementById("searchCode").value = '';  // Limpia el valor del campo Código
    document.getElementById("searchRazonSocial").value = '';  // Limpia el valor del campo Razón Social
    document.getElementById("searchNumber").value = '';  // Limpia el valor del campo Número
}

// Función para habilitar el campo Código cuando se selecciona 'Por R.U.C.'
function enableCodeOnRUC() {
    document.getElementById("searchCode").disabled = false;  // Habilita el campo Código
    document.getElementById("searchRazonSocial").disabled = true;  // Deshabilita el campo Razón Social
    document.getElementById("searchNumber").disabled = true;  // Deshabilita el campo Número
}

// Función para habilitar el campo Razón Social cuando se selecciona 'Por Razón Social'
function enableRazonSocialOnRazonSocial() {
    document.getElementById("searchRazonSocial").disabled = false;  // Habilita el campo Razón Social
    document.getElementById("searchCode").disabled = true;  // Deshabilita el campo Código
    document.getElementById("searchNumber").disabled = true;  // Deshabilita el campo Número
}
