<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis 15 Años - Planificador y Directorio</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="navbar">
        <div class="container nav-container"> 
          <a href="index.php" class="logo">
    <img src="img/logo.png" alt="Logo" style="width: 240px; height: auto; margin-right: 10px; vertical-align: middle;">
    <div class="logo-text">Recuerdos <span>Inolvidables</span></div>
</a>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Inicio</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><span class="user-welcome">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span></li>
                        <li><a href="index.php?controller=auth&action=logout" class="btn-logout">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="index.php?controller=auth&action=login">Iniciar Sesión</a></li>
                        <li><a href="index.php?controller=auth&action=register" class="btn-nav">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">