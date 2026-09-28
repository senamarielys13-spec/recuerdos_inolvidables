<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="max-width: 600px; margin: 30px auto; padding: 25px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); font-family: Arial, sans-serif;">
    <h2 style="color: #e6196e; margin-top: 0;">✏️ Editar Proveedor</h2>

    <form action="index.php?controller=proveedor&action=actualizar" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <input type="hidden" name="id_proveedor" value="<?= $proveedor['id_proveedor'] ?>">

        <div>
            <label style="font-weight: bold; font-size: 14px;">Nombre Comercial / Empresa *</label>
            <input type="text" name="nombre_comercial" value="<?= htmlspecialchars($proveedor['nombre_comercial']) ?>" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div>
            <label style="font-weight: bold; font-size: 14px;">Categoría *</label>
            <select name="id_categoria" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
                <option value="">-- Selecciona una Categoría --</option>
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>" <?= ($proveedor['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; font-size: 14px;">Teléfono (WhatsApp)</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($proveedor['telefono'] ?? '') ?>" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; font-size: 14px;">Correo Electrónico</label>
                <input type="email" name="email" value="<?= htmlspecialchars($proveedor['email'] ?? '') ?>" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>
        </div>

        <div>
            <label style="font-weight: bold; font-size: 14px;">Dirección / Ubicación</label>
            <input type="text" name="direccion" value="<?= htmlspecialchars($proveedor['direccion'] ?? '') ?>" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div>
            <label style="font-weight: bold; font-size: 14px;">Descripción del Servicio</label>
            <textarea name="descripcion" rows="3" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;"><?= htmlspecialchars($proveedor['descripcion'] ?? '') ?></textarea>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; background: #fff5f8; padding: 10px; border-radius: 6px;">
            <input type="checkbox" name="es_destacado" id="es_destacado" value="1" <?= (!empty($proveedor['es_destacado']) && $proveedor['es_destacado'] == 1) ? 'checked' : '' ?> style="width: 18px; height: 18px;">
            <label for="es_destacado" style="font-weight: bold; font-size: 14px; color: #900c3f; cursor: pointer;">
                ⭐ Marcar como Proveedor Destacado
            </label>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
            <a href="index.php?controller=proveedor&action=index" style="color: #666; text-decoration: none; padding: 10px 15px;">Cancelar</a>
            <button type="submit" style="background: #e6196e; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Actualizar Proveedor</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>