<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="directory-header">
    <h1>Directorio de Proveedores para tus 15 Años</h1>
    <p>Encuentra los mejores salones, fotógrafos, vestidos y banquetes en un solo lugar.</p>
</section>

<section class="filters">
    <a href="index.php?controller=proveedor&action=index" class="btn-filter <?php echo empty($_GET['categoria']) ? 'active' : ''; ?>">Todas</a>
    <?php foreach ($categorias as $cat): ?>
        <a href="index.php?controller=proveedor&action=index&categoria=<?php echo $cat['id_categoria']; ?>" 
           class="btn-filter <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($cat['nombre']); ?>
        </a>
    <?php endforeach; ?>
</section>

<section class="providers-grid">
    <?php if (!empty($proveedores)): ?>
        <?php foreach ($proveedores as $p): ?>
            <div class="card <?php echo $p['destacado'] ? 'card-destacado' : ''; ?>">
                <?php if ($p['destacado']): ?>
                    <span class="badge">Destacado</span>
                <?php endif; ?>
                <div class="card-body">
                    <span class="category-tag"><?php echo htmlspecialchars($p['categoria']); ?></span>
                    <h3><?php echo htmlspecialchars($p['nombre_comercial']); ?></h3>
                    <p class="location">📍 <?php echo htmlspecialchars($p['ubicacion']); ?></p>
                    <p class="description"><?php echo htmlspecialchars($p['descripcion']); ?></p>
                    <p class="phone">📞 <?php echo htmlspecialchars($p['telefono_contacto']); ?></p>
                    <a href="index.php?controller=contacto&id=<?php echo $p['id_proveedor']; ?>" class="btn-primary">Solicitar Cotización</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-results">No se encontraron proveedores en esta categoría.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>