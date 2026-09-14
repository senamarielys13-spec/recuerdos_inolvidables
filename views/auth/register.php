<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="auth-container">
    <div class="auth-box">
        <h2>Crear Cuenta</h2>
        <p>Únete para planificar tu evento o registrar tus servicios como proveedor.</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?> 
                <a href="index.php?controller=auth&action=login">Iniciar sesión</a>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=register" method="POST" class="auth-form">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej: Maria Lopez">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono / WhatsApp</label>
                <input type="text" id="telefono" name="telefono" placeholder="555-0000">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="******">
            </div>

            <div class="form-group">
                <label for="id_rol">Tipo de Cuenta</label>
                <select name="id_rol" id="id_rol" class="form-select">
                    <option value="2">Organizador / Quinceañera (Cliente)</option>
                    <option value="3">Proveedor de Servicios</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Registrarse</button>
        </form>

        <p class="auth-switch">¿Ya tienes cuenta? <a href="index.php?controller=auth&action=login">Inicia sesión</a></p>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>