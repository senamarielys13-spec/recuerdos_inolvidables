<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="padding: 40px 20px; min-height: 50vh;">
    <h2 style="color: #e6196e;">🛒 Tu Carrito de Cotizaciones / Compras</h2>
    <p>Revisa los servicios y productos seleccionados para tu evento.</p>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div style="background: #f8f9fa; padding: 40px; text-align: center; border-radius: 8px; margin-top: 20px; border: 1px solid #ddd;">
            <p style="font-size: 18px; color: #666; margin-bottom: 15px;">Tu carrito está vacío en este momento.</p>
            <a href="index.php?controller=evento&action=index" style="display: inline-block; padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Explorar Eventos y Servicios</a>
        </div>
    <?php else: ?>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; background: white; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; border: 1px solid #ddd;">Servicio / Producto</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Precio Estimado</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Cantidad</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Subtotal</th>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['carrito'] as $id => $item): 
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($item['nombre']) ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd;">$<?= number_format($item['precio'], 2) ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd;"><?= $item['cantidad'] ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd;">$<?= number_format($subtotal, 2) ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                        <a href="index.php?controller=carrito&action=eliminar&id=<?= $id ?>" style="display: inline-block; padding: 6px 12px; background: white; color: #e6196e; border: 1px solid #e6196e; text-decoration: none; border-radius: 4px;">Quitar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background: #f8f9fa;">
                    <td colspan="3" style="padding: 12px; text-align: right; border: 1px solid #ddd;">Total Estimado:</td>
                    <td colspan="2" style="padding: 12px; color: #e6196e; font-size: 18px; border: 1px solid #ddd;">$<?= number_format($total, 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php?controller=carrito&action=vaciar" style="padding: 10px 15px; color: #666; text-decoration: underline;" onclick="return confirm('¿Deseas vaciar todo el carrito?');">Vaciar Carrito</a>
            <div>
                <a href="index.php?controller=evento&action=index" style="padding: 10px 20px; background: #ccc; color: #333; text-decoration: none; border-radius: 5px; margin-right: 10px;">Seguir Comprando</a>
                <a href="index.php?controller=carrito&action=confirmar" style="padding: 10px 20px; background: #e6196e; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Enviar Cotización</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>