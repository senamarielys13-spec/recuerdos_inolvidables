<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Panel de Reportes y Administración</h2>
        <span class="badge bg-danger fs-6">Administrador</span>
    </div>

    <!-- Tarjetas de Resumen de Reportes -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Usuarios</h5>
                    <h2 class="fw-bold text-primary">24</h2>
                    <p class="card-text text-muted small">Clientes y Proveedores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <h5 class="card-title text-muted">Eventos Creados</h5>
                    <h2 class="fw-bold text-success">12</h2>
                    <p class="card-text text-muted small">Quinceañeras activas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <h5 class="card-title text-muted">Proveedores</h5>
                    <h2 class="fw-bold text-info">8</h2>
                    <p class="card-text text-muted small">Servicios activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <h5 class="card-title text-muted">Solicitudes</h5>
                    <h2 class="fw-bold text-warning">15</h2>
                    <p class="card-text text-muted small">Cotizaciones pendientes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Eventos / Actividad Reciente -->
    <div class="card shadow-sm border-0 p-4">
        <h4 class="mb-3">Eventos Recientes registrados</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Tipo de Evento</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>María López</td>
                        <td>Mis 15 Años</td>
                        <td>15/10/2026</td>
                        <td><span class="badge bg-success">Confirmado</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Isamar Camacho</td>
                        <td>Mis 15 Años</td>
                        <td>28/11/2026</td>
                        <td><span class="badge bg-warning text-dark">En proceso</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>