<?php
include('connection.php');

// Variables de paginación
$recordsPerPage = 10; // Número de registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$offset = ($page - 1) * $recordsPerPage; // Calcular el OFFSET

// Consulta para contar el total de registros
$totalQuery = "SELECT COUNT(*) as total FROM public.sotapedi";
$totalResult = $pdo->query($totalQuery);
$totalRecords = $totalResult->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Consulta para obtener los datos paginados
$query = "
SELECT nroo_c, fcho_c, coddid, nrodid, sigase, nomcli, 
    CASE 
        WHEN codmon = '2' THEN 'US$' 
        ELSE 'S/.' 
    END AS moneda, 
    CASE 
        WHEN totnet <> 0 THEN totnet::TEXT 
        ELSE '' 
    END AS total_neto, 
    estfac, fchrcp, hrarcp, codcmp, codpgo, nrodoc
FROM public.sotapedi
LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admisiones</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <div class="column">
        <div class="section">
            <h1>Clientes</h1>
            <div class="filters">
                <label>
                    <input type="radio" name="filter" value="all" onclick="applyFilters()"> Todos
                </label>
                <label>
                    <input type="radio" name="filter" value="ruc" onclick="enableCodeField()"> Por R.U.C
                </label>
                <label>
                    <input type="radio" name="filter" value="razon_social" onclick="enableRazonSocialField()"> Por razón social
                </label>
            </div>
            <div class="search">
                <input type="text" id="searchCode" placeholder="Código" disabled>
                <input type="text" id="searchRazonSocial" placeholder="Razón Social" disabled>
            </div>
        </div>
        <div class="section">
            <h1>Búsqueda</h1>
            <div class="search-filters">
                <label>
                    <input type="radio" name="searchFilter" value="all" onclick="disableSearchField()"> Todos
                </label>
                <label>
                    <input type="radio" name="searchFilter" value="number" onclick="enableSearchField('number')"> Por Número
                </label>
                <label>
                    <input type="radio" name="searchFilter" value="name" onclick="enableSearchField('name')"> Por Nombre
                </label>
            </div>
            <div class="search">
                <input type="text" id="searchNumber" placeholder="Número" disabled>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="section">
            <h1>Estado de órdenes</h1>
            <div class="order-status">
                <label>
                    <input type="radio" name="orderStatus" value="pending" onclick="applyFilters()"> Pendiente
                </label>
                <label>
                    <input type="radio" name="orderStatus" value="completed" onclick="applyFilters()"> Terminado
                </label>
                <label>
                    <input type="radio" name="orderStatus" value="code" onclick="applyFilters()"> Un código
                </label>
                <label>
                    <input type="radio" name="orderStatus" value="all" onclick="applyFilters()"> Todos
                </label>
            </div>
            <div class="order-search">
                <input type="text" id="searchOrderStatus" placeholder="Estado">
            </div>
        </div>
        <div class="section">
            <h1>Rango de fechas</h1>
            <div class="date-range-filters">
                <label>
                    <input type="radio" name="dateRange" value="all" onclick="disableDateFields()"> Todos
                </label>
                <label>
                    <input type="radio" name="dateRange" value="range" onclick="enableDateFields()"> Un rango
                </label>
            </div>
            <div class="date-range-search">
                <input type="date" id="startDate" placeholder="Fecha de inicio" disabled>
                <input type="date" id="endDate" placeholder="Fecha de fin" disabled>
            </div>
            <div class="button-wrapper">
                <button onclick="applyFilters()">Buscar</button>
            </div>
        </div>
    </div>
</div>

<!-- Grilla -->
<div class="data-grid">
    <h2>Datos de la Tabla sotapedi</h2>
    <?php if (!empty($data)): ?>
        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
                        <?php
                            $columns = array_keys($data[0]);
                            foreach ($columns as $column) {
                                echo "<th>" . ucfirst(str_replace('_', ' ', $column)) . "</th>";
                            }
                        ?>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($row as $key => $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                            <td>
                                <button class="action-btn edit-btn">Editar</button>
                                <button class="action-btn detail-btn">Detalle</button>
                                <button class="action-btn delete-btn">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="prev-btn">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="page-btn <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="next-btn">Siguiente</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>No se encontraron datos.</p>
    <?php endif; ?>
</div>

<script src="Java_Admi.js"></script>
</body>
</html>
