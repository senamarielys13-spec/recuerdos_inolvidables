<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 50vh;">
    <h2 style="color: #e6196e;">Directorio de Clientes</h2>
    <p>Gestiona la información de tus clientes registrados.</p>
    
    <a href="index.php?controller=usuario&action=crear" style="display: inline-block; padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">+ Nuevo Cliente</a>

    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; background: white;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Nombre</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Correo Electrónico</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Teléfono</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $u): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= $u['id_usuario'] ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($u['nombre']) ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($u['email']) ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($u['telefono'] ?? 'Sin registrar') ?></td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                    <a href="index.php?controller=usuario&action=editar&id=<?= $u['id_usuario'] ?>" style="display: inline-block; padding: 6px 12px; background: #e6196e; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 8px;">✏️ Editar</a>
                    <a href="index.php?controller=usuario&action=eliminar&id=<?= $u['id_usuario'] ?>" style="display: inline-block; padding: 6px 12px; background: white; color: #e6196e; border: 1px solid #e6196e; text-decoration: none; border-radius: 4px; font-size: 14px;" onclick="return confirm('¿Deseas eliminar este cliente?');">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>