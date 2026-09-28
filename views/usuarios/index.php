<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 50vh;">
    <h2 style="color: #e6196e;">Directorio de Clientes</h2>
    <p>Gestiona la información de tus clientes registrados.</p>

    <!-- [NUEVO/MODIFICADO] Solo el Administrador puede ver el botón de Agregar Nuevo -->
    <?php if (isset($_SESSION['user_rol']) && ($_SESSION['user_rol'] == 1 || (isset($_SESSION['user_rol_nombre']) && $_SESSION['user_rol_nombre'] === 'Administrador'))): ?>
        <a href="index.php?controller=usuario&action=crear" style="display: inline-block; padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">+ Agregar Nuevo</a>
    <?php endif; ?>

    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; background: white;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Nombre</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Correo Electrónico</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Teléfono</th>
                
                <!-- [NUEVO/MODIFICADO] La columna Acciones solo se muestra al Administrador -->
                <?php if (isset($_SESSION['user_rol']) && ($_SESSION['user_rol'] == 1 || (isset($_SESSION['user_rol_nombre']) && $_SESSION['user_rol_nombre'] === 'Administrador'))): ?>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $u): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;"><?=$u['id_usuario']?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?=htmlspecialchars($u['nombre'])?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?=htmlspecialchars($u['email'])?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?=htmlspecialchars($u['telefono'] ?? 'Sin registrar')?></td>
                
                <!-- [NUEVO/MODIFICADO] Los botones Editar y Eliminar solo se muestran si es Administrador -->
                <?php if (isset($_SESSION['user_rol']) && ($_SESSION['user_rol'] == 1 || (isset($_SESSION['user_rol_nombre']) && $_SESSION['user_rol_nombre'] === 'Administrador'))): ?>
                    <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                        <a href="index.php?controller=usuario&action=editar&id=<?=$u['id_usuario']?>" style="display: inline-block; padding: 6px 12px; background: #e6196e; color: white; text-decoration: none; border-radius: 4px;">Editar</a>
                        <a href="index.php?controller=usuario&action=eliminar&id=<?=$u['id_usuario']?>" style="display: inline-block; padding: 6px 12px; background: white; color: #e6196e; border: 1px solid #e6196e; text-decoration: none; border-radius: 4px;" onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">Eliminar</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>