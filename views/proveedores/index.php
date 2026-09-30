<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 50vh;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="color: #e6196e; margin: 0 0 5px 0;">Directorio de Proveedores</h2>
            <p style="color: #666; margin: 0;">Encuentra los mejores salones, fotógrafos, vestidos y banquetes en un solo lugar.</p>
        </div>

        <?php if (isset($_SESSION['user_rol']) && ($_SESSION['user_rol'] == 1 || (isset($_SESSION['user_rol_nombre']) && $_SESSION['user_rol_nombre'] === 'Administrador'))): ?>
            <a href="index.php?controller=proveedor&action=crear" style="padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px;">+ Nuevo Proveedor</a>
        <?php endif; ?>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php if (!empty($proveedores)): ?>
            <?php foreach ($proveedores as $p): ?>
                <?php 
                    // Obtener el nombre directamente de las columnas de la BD
                    $nombre_proveedor = '';
                    $posibles_campos = ['nombre_empresa', 'nombre_comercial', 'empresa', 'nombre_proveedor', 'nombre', 'razon_social', 'titulo'];
                    
                    foreach ($posibles_campos as $campo) {
                        if (!empty($p[$campo]) && trim($p[$campo]) !== '') {
                            $nombre_proveedor = trim($p[$campo]);
                            break;
                        }
                    }

                    if ($nombre_proveedor === '') {
                        $nombre_proveedor = 'Sin nombre (Editar)';
                    }

                    // Categoría
                    $categoria_proveedor = '';
                    $posibles_cat = ['categoria', 'nombre_categoria', 'tipo'];
                    foreach ($posibles_cat as $campo) {
                        if (!empty($p[$campo]) && trim($p[$campo]) !== '') {
                            $categoria_proveedor = trim($p[$campo]);
                            break;
                        }
                    }
                    if ($categoria_proveedor === '') {
                        $categoria_proveedor = 'PROVEEDOR VERIFICADO';
                    }
                ?>
                <div style="width: calc(33.333% - 14px); min-width: 280px; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: bold; color: #888; text-transform: uppercase;">
                                <?= htmlspecialchars($categoria_proveedor) ?>
                            </span>
                            <?php if (!empty($p['destacado'])): ?>
                                <span style="font-size: 12px; background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 10px; font-weight: bold;">⭐ Destacado</span>
                            <?php endif; ?>
                        </div>

                        <h3 style="margin: 0 0 10px 0; color: #333; font-size: 18px; font-weight: bold;">
                            <?= htmlspecialchars($nombre_proveedor) ?>
                        </h3>
                        
                        <p style="font-size: 13px; color: #666; margin-bottom: 12px; line-height: 1.4;">
                            <?= htmlspecialchars(!empty($p['descripcion']) ? $p['descripcion'] : (!empty($p['descripcion_servicio']) ? $p['descripcion_servicio'] : 'Sin descripción')) ?>
                        </p>
                        
                        <p style="font-size: 13px; color: #444; margin: 4px 0;">📍 <?= htmlspecialchars(!empty($p['direccion']) ? $p['direccion'] : (!empty($p['ubicacion']) ? $p['ubicacion'] : 'Sin dirección')) ?></p>
                        <p style="font-size: 13px; color: #444; margin: 4px 0;">📞 <?= htmlspecialchars(!empty($p['telefono']) ? $p['telefono'] : (!empty($p['celular']) ? $p['celular'] : 'Sin teléfono')) ?></p>
                        <p style="font-size: 13px; color: #444; margin: 4px 0;">✉️ <?= htmlspecialchars(!empty($p['email']) ? $p['email'] : (!empty($p['correo']) ? $p['correo'] : 'Sin correo')) ?></p>
                    </div>

                    <div style="margin-top: 15px;">
                        <a href="mailto:<?= htmlspecialchars(!empty($p['email']) ? $p['email'] : (!empty($p['correo']) ? $p['correo'] : '')) ?>" style="display: block; text-align: center; padding: 10px; background: #e6196e; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 13px;">Solicitar Cotización</a>
                        <form action="index.php?controller=carrito&action=agregar" method="POST" style="margin-top: 8px;">
    <input type="hidden" name="id" value="<?= $p['id_proveedor'] ?? $p['id'] ?>">
    <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre_proveedor) ?>">
    <input type="hidden" name="precio" value="<?= $p['precio'] ?? 0 ?>">
    <button type="submit" style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 13px; cursor: pointer;">
        🛒 Agregar al Carrito
    </button>
</form>

                        <?php if (isset($_SESSION['user_rol']) && ($_SESSION['user_rol'] == 1 || (isset($_SESSION['user_rol_nombre']) && $_SESSION['user_rol_nombre'] === 'Administrador'))): ?>
                            <div style="display: flex; justify-content: space-around; border-top: 1px solid #eee; padding-top: 10px; margin-top: 12px;">
                                <a href="index.php?controller=proveedor&action=editar&id=<?= $p['id_proveedor'] ?? $p['id'] ?>" style="color: #555; text-decoration: none; font-size: 13px; font-weight: 500;">✏ Editar</a>
                                <a href="index.php?controller=proveedor&action=eliminar&id=<?= $p['id_proveedor'] ?? $p['id'] ?>" style="color: #e6196e; text-decoration: none; font-size: 13px; font-weight: 500;" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');">🗑️ Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="width: 100%; text-align: center; color: #666; padding: 40px;">No hay proveedores registrados por el momento.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>