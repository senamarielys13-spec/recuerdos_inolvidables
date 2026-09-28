<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: Arial, sans-serif;">

    <!-- Encabezado y botón principal -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #e6196e; margin: 0 0 5px 0; font-size: 26px; font-weight: bold;">
                Directorio de Proveedores
            </h2>
            <p style="color: #666; margin: 0; font-size: 15px;">
                Encuentra los mejores salones, fotógrafos, vestidos y banquetes en un solo lugar.
            </p>
        </div>
        
        <a href="index.php?controller=proveedor&action=crear" 
           style="background-color: #e6196e; color: white; padding: 12px 22px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(230, 25, 110, 0.25);">
            + Nuevo Proveedor
        </a>
    </div>

    <!-- Botones de Filtro dinámicos desde Base de Datos -->
    <div style="display: flex; gap: 10px; margin-bottom: 30px; overflow-x: auto; padding-bottom: 10px;">
        <button class="filter-btn active" onclick="filtrarCategoria('todas', this)" style="background: #900c3f; color: white; border: none; padding: 10px 20px; border-radius: 20px; font-weight: bold; cursor: pointer; font-size: 13px; white-space: nowrap;">
            Todas
        </button>
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <button class="filter-btn" onclick="filtrarCategoria('<?= $cat['id_categoria'] ?>', this)" style="background: #f0f0f0; color: #444; border: 1px solid #ddd; padding: 10px 20px; border-radius: 20px; font-weight: 500; cursor: pointer; font-size: 13px; white-space: nowrap;">
                    <?= htmlspecialchars($cat['nombre']) ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Grid de Tarjetas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 25px;">
        
        <?php if (!empty($proveedores)): ?>
            <?php foreach ($proveedores as $p): ?>
                <div class="card-proveedor" 
                     data-categoria="<?= htmlspecialchars($p['id_categoria'] ?? '') ?>"
                     style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between;">
                    
                    <div>
                        <!-- Encabezado de la Tarjeta y Badge de Destacado -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; min-height: 24px;">
                            <span style="color: #900c3f; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                PROVEEDOR VERIFICADO
                            </span>
                            
                            <?php if (!empty($p['es_destacado']) && $p['es_destacado'] == 1): ?>
                                <span style="background: #900c3f; color: white; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 12px; text-transform: uppercase;">
                                    DESTACADO
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Nombre -->
                        <h3 style="margin: 0 0 8px 0; color: #1a202c; font-size: 20px; font-weight: bold;">
                            <?= htmlspecialchars($p['nombre_comercial']) ?>
                        </h3>

                        <!-- Ubicación -->
                        <p style="margin: 0 0 10px 0; color: #718096; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            📍 <?= !empty($p['direccion']) ? htmlspecialchars($p['direccion']) : 'Ubicación disponible tras cotizar' ?>
                        </p>

                        <!-- Texto Explicativo Personalizado -->
                        <div style="margin-bottom: 15px; background: #fafafa; padding: 10px; border-radius: 8px; border-left: 3px solid #e6196e;">
                            <p style="margin: 0; color: #4a5568; font-size: 13px; line-height: 1.4;">
                                <?= !empty($p['descripcion']) ? htmlspecialchars($p['descripcion']) : 'Servicios especializados para fiestas de 15 años.' ?>
                            </p>
                        </div>

                        <!-- Datos de Contacto -->
                        <div style="font-size: 13px; color: #4a5568; margin-bottom: 20px; display: flex; flex-direction: column; gap: 4px;">
                            <p style="margin: 0;">📞 <?= !empty($p['telefono']) ? htmlspecialchars($p['telefono']) : 'No registrado' ?></p>
                            <?php if (!empty($p['email'])): ?>
                                <p style="margin: 0;">✉️ <?= htmlspecialchars($p['email']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Cotización por WhatsApp / Email -->
                    <div>
                        <?php 
                            $telLimpio = preg_replace('/[^0-9]/', '', $p['telefono'] ?? '');
                            $mensajeWhatsApp = rawurlencode("Hola, vi tu servicio de '" . ($p['nombre_comercial'] ?? '') . "' en Recuerdos Inolvidables y me gustaría solicitar información para mis 15 años.");
                            
                            $linkCotizar = !empty($telLimpio) 
                                ? "https://wa.me/" . $telLimpio . "?text=" . $mensajeWhatsApp 
                                : "mailto:" . ($p['email'] ?? '') . "?subject=Solicitud de Cotización 15 Años";
                        ?>

                        <a href="<?= $linkCotizar ?>" target="_blank"
                           style="display: block; width: 100%; text-align: center; background-color: #c2185b; color: white; padding: 10px 0; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; margin-bottom: 12px; box-sizing: border-box;">
                            Solicitar Cotización por WhatsApp / Correo
                        </a>

                        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #f0f0f0; padding-top: 10px;">
                            <a href="index.php?controller=proveedor&action=editar&id=<?= $p['id_proveedor'] ?>" 
                               style="color: #c2185b; text-decoration: none; font-size: 12px; font-weight: bold; padding: 4px 10px; border: 1px solid #c2185b; border-radius: 5px;">
                                ✏️ Editar
                            </a>
                            <a href="index.php?controller=proveedor&action=eliminar&id=<?= $p['id_proveedor'] ?>" 
                               onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');"
                               style="color: #e53e3e; text-decoration: none; font-size: 12px; font-weight: bold; padding: 4px 10px; border: 1px solid #fed7d7; border-radius: 5px; background: #fff5f5;">
                                🗑️ Eliminar
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #f9f9f9; border-radius: 12px; color: #666;">
                <p style="font-size: 16px; margin: 0;">No hay proveedores registrados aún.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
function filtrarCategoria(catId, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.style.background = '#f0f0f0';
        b.style.color = '#444';
        b.style.border = '1px solid #ddd';
    });
    btn.style.background = '#900c3f';
    btn.style.color = 'white';
    btn.style.border = 'none';

    const cards = document.querySelectorAll('.card-proveedor');
    cards.forEach(card => {
        const cardCat = card.getAttribute('data-categoria');
        if (catId === 'todas' || cardCat === catId) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>