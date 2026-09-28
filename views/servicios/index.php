<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 50vh;">
    <h2 style="color: #e6196e;">Catálogo de Productos y Servicios</h2>
    <p>Administra las opciones ofrecidas para las fiestas de 15 años.</p>
    
    <a href="index.php?controller=servicio&action=crear" style="display: inline-block; padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">+ Nuevo Producto / Servicio</a>

    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; background: white;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Producto</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Categoría</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Precio</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($servicios as $s): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= $s['id_servicio'] ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;">
                    <strong><?= htmlspecialchars($s['nombre']) ?></strong><br>
                    <small style="color: #666;"><?= htmlspecialchars($s['descripcion']) ?></small>
                </td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($s['categoria'] ?? 'Sin categoría') ?></td>
                <td style="padding: 12px; border: 1px solid #ddd; font-weight: bold; color: #e6196e;">$<?= number_format($s['precio'], 2) ?></td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                    <a href="index.php?controller=servicio&action=editar&id=<?= $s['id_servicio'] ?>" style="display: inline-block; padding: 6px 12px; background: #e6196e; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 8px;">✏️ Editar</a>
                    <a href="index.php?controller=servicio&action=eliminar&id=<?= $s['id_servicio'] ?>" style="display: inline-block; padding: 6px 12px; background: white; color: #e6196e; border: 1px solid #e6196e; text-decoration: none; border-radius: 4px; font-size: 14px;" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>