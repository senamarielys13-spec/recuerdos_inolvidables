<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis 15 Años - Planificador y Directorio</title>
    <link rel="stylesheet" href="/recuerdos_inolvidables/public/css/styles.css?v=4">
</head>
<body>
    <header class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <img src="img/logo.png" alt="Logo"
                     style="width: 240px; height: auto; margin-right: 10px; vertical-align: middle;">
                <div class="logo-text">Recuerdos <span>Inolvidables</span></div>
            </a>

            <nav>
                <ul class="nav-links">

                    <li><a href="index.php">Inicio</a></li>

                    <li>
                        <a href="index.php?controller=quienesSomos&action=index">
                            Quiénes somos
                        </a>
                    </li>

                    <!-- Botón superior de tratamiento de datos -->
                    <li>
                        <a href="#" id="abrirDatosMenu">
                            🛡 Tratamiento de datos
                        </a>
                    </li>

                    <li>
                        <a href="index.php?controller=evento&action=index">
                            Eventos
                        </a>
                    </li>

                    <li>
                        <a href="index.php?controller=carrito&action=index">
                            🛒 Carrito
                        </a>
                    </li>

                    <!-- Opciones exclusivas para administradores -->
                    <?php if (
                        isset($_SESSION['user_rol']) &&
                        (
                            $_SESSION['user_rol'] == 1 ||
                            (
                                isset($_SESSION['user_rol_nombre']) &&
                                $_SESSION['user_rol_nombre'] === 'Administrador'
                            )
                        )
                    ): ?>
                        <li>
                            <a href="index.php?controller=reporte&action=index"
                               style="color: #e6196e; font-weight: bold;">
                                📊 Reportes
                            </a>
                        </li>

                        <li>
                            <a href="index.php?controller=usuario&action=index"
                               style="color: #e6196e; font-weight: bold;">
                                👥 Clientes
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Opciones según el estado de sesión -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <span class="user-welcome">
                                Hola, <?php
                                    echo htmlspecialchars($_SESSION['user_nombre']);
                                ?>
                            </span>
                        </li>

                        <li>
                            <a href="index.php?controller=auth&action=logout"
                               class="btn-logout">
                                Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="index.php?controller=auth&action=login">
                                Iniciar Sesión
                            </a>
                        </li>

                        <li>
                            <a href="index.php?controller=auth&action=register"
                               class="btn-nav">
                                Registro
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </header>

    <!-- Ventana emergente de tratamiento de datos -->
    <div id="avisoDatos" class="datos-overlay"
         role="dialog" aria-modal="true"
         aria-labelledby="tituloDatos" hidden>

        <div class="datos-modal">

            <div class="datos-cabecera">
                <h2 id="tituloDatos">🛡 Tratamiento de datos</h2>

                <button type="button" id="cerrarDatos"
                        class="datos-cerrar" aria-label="Cerrar aviso">
                    &times;
                </button>
            </div>

            <div class="datos-contenido">
                <p>
                    En <strong>Recuerdos Inolvidables</strong>, los datos
                    personales que proporciones se utilizarán para gestionar
                    tu cuenta, organizar eventos y facilitar el contacto con
                    proveedores, según las finalidades del proyecto.
                </p>

                <p>
                    Tus datos deben tratarse de forma segura y utilizarse
                    únicamente para las finalidades informadas, conforme
                    a la política de tratamiento de datos aplicable.
                </p>

                <p>
                    Consulta la política de privacidad para conocer cómo
                    se utilizan tus datos y cómo puedes ejercer tus derechos.
                </p>
            </div>

            <div class="datos-acciones">
                <button type="button" id="entendidoDatos">
                    Entendido
                </button>
            </div>

        </div>
    </div>

    <style>
        .datos-overlay[hidden] {
            display: none !important;
        }

        .datos-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.55);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
        }

        .datos-modal {
            width: 100%;
            max-width: 480px;
            background: #fffafc;
            border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            color: #333;
        }

        .datos-cabecera {
            background: #292e32;
            color: white;
            padding: 15px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .datos-cabecera h2 {
            font-size: 18px;
            margin: 0;
        }

        .datos-cerrar {
            color: white;
            background: transparent;
            border: none;
            font-size: 28px;
            cursor: pointer;
        }

        .datos-contenido {
            padding: 20px;
            line-height: 1.7;
            font-size: 14px;
        }

        .datos-acciones {
            padding: 0 18px 18px;
            display: flex;
            justify-content: flex-end;
        }

        #entendidoDatos {
            background: #e9b900;
            color: #292929;
            border: none;
            border-radius: 5px;
            padding: 11px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        #entendidoDatos:hover {
            background: #d4a900;
        }
    </style>

    <script>
    (function () {
        const aviso = document.getElementById('avisoDatos');
        const cerrar = document.getElementById('cerrarDatos');
        const entendido = document.getElementById('entendidoDatos');
        const abrirMenu = document.getElementById('abrirDatosMenu');

        if (!aviso || !cerrar || !entendido || !abrirMenu) return;

        function mostrarAviso() {
            aviso.hidden = false;
            entendido.focus();
        }

        function cerrarAviso() {
            aviso.hidden = true;

            try {
                localStorage.setItem('avisoDatosVisto', '1');
            } catch (e) {
                // El aviso se puede cerrar aunque el almacenamiento esté bloqueado.
            }
        }

        abrirMenu.addEventListener('click', function (evento) {
            evento.preventDefault();
            mostrarAviso();
        });

        cerrar.addEventListener('click', cerrarAviso);
        entendido.addEventListener('click', cerrarAviso);

        // Mostrar automáticamente la primera vez que se visita el sitio.
        try {
            if (localStorage.getItem('avisoDatosVisto') !== '1') {
                mostrarAviso();
            }
        } catch (e) {
            mostrarAviso();
        }

        document.addEventListener('keydown', function (evento) {
            if (evento.key === 'Escape' && !aviso.hidden) {
                cerrarAviso();
            }
        });
    })();
    </script>

    <main class="container">
