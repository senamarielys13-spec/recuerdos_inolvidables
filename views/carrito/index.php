<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 60vh;">
    <div style="margin-bottom: 25px;">
        <h2 style="color: #e6196e; margin: 0 0 5px 0; font-size: 26px; font-weight: bold;">🛒 Tu Carrito de Cotizaciones / Compras</h2>
        <p style="color: #666; margin: 0;">Revisa los servicios y productos seleccionados para tu evento.</p>
    </div>

    <?php if (!empty($carrito)): ?>
        <div style="background: white; border-radius: 10px; border: 1px solid #e0e0e0; box-shadow: 0 4px 10px rgba(0,0,0,0.05); padding: 25px;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; text-align: left; color: #555; font-size: 14px;">
                        <th style="padding: 12px;">Servicio / Producto</th>
                        <th style="padding: 12px;">Precio Unit.</th>
                        <th style="padding: 12px; text-align: center;">Cantidad</th>
                        <th style="padding: 12px; text-align: right;">Subtotal</th>
                        <th style="padding: 12px; text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($carrito as $item): 
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>
                        <tr style="border-bottom: 1px solid #eee; font-size: 14px; color: #333;">
                            <td style="padding: 15px; font-weight: bold; color: #e6196e;">
                                <?= htmlspecialchars($item['nombre']) ?>
                            </td>
                            <td style="padding: 15px;">
                                $<?= number_format($item['precio'], 2) ?>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <?= $item['cantidad'] ?>
                            </td>
                            <td style="padding: 15px; text-align: right; font-weight: bold;">
                                $<?= number_format($subtotal, 2) ?>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="index.php?controller=carrito&action=eliminar&id=<?= urlencode($item['id']) ?>" 
                                   style="color: #dc3545; text-decoration: none; font-size: 13px; font-weight: bold;">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #f5f5f5; padding-top: 20px;">
                <a href="index.php?controller=carrito&action=vaciar" 
                   style="color: #666; text-decoration: none; font-size: 13px; border: 1px solid #ccc; padding: 8px 15px; border-radius: 6px;">
                   Vaciar Carrito
                </a>

                <div style="text-align: right;">
                    <span style="font-size: 16px; color: #555; margin-right: 15px;">Total Estimado:</span>
                    <strong style="font-size: 22px; color: #e6196e;">$<?= number_format($total, 2) ?></strong>
                </div>
            </div>

            <div style="margin-top: 25px; text-align: right;">
                <a href="index.php?controller=proveedor&action=index" 
                   style="padding: 12px 20px; border: 1px solid #e6196e; color: #e6196e; text-decoration: none; border-radius: 6px; font-weight: bold; margin-right: 10px;">
                   Seguir Explorando
                </a>
                <button onclick="alert('¡Cotización/Pedido enviado con éxito!')" 
                        style="padding: 12px 25px; background: #e6196e; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer;">
                   Procesar Cotización
                </button>
            </div>
        </div>

    <?php else: ?>
        <div style="background: white; border-radius: 10px; border: 1px solid #e0e0e0; text-align: center; padding: 50px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <p style="color: #666; font-size: 16px; margin-bottom: 20px;">Tu carrito está vacío en este momento.</p>
            <a href="index.php?controller=proveedor&action=index" 
               style="padding: 12px 25px; background: #e6196e; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; display: inline-block;">
               Explorar Eventos y Servicios
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>