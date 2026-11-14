
<?php

/*
 * RECUERDOS INOLVIDABLES
 * Vista principal de proveedores
 *
 * Funciones:
 * 1. Mostrar el directorio de proveedores.
 * 2. Registrar intentos de contacto por WhatsApp.
 * 3. Guardar proveedores en Mis notas.
 * 4. Mostrar herramientas al administrador.
 */

// Iniciar sesión cuando sea necesario.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Token de seguridad para Mis notas.

if (empty($_SESSION['notas_csrf'])) {
    $_SESSION['notas_csrf'] = bin2hex(
        random_bytes(32)
    );
}

// Token de seguridad para contactos por WhatsApp.

if (empty($_SESSION['contacto_csrf'])) {
    $_SESSION['contacto_csrf'] = bin2hex(
        random_bytes(32)
    );
}

// Identificar la cuenta administrativa.

$esAdministradorProveedor =
    !empty($_SESSION['user_id']) &&
    (int) ($_SESSION['user_rol'] ?? 0) === 1;

// Imágenes de las nueve tarjetas.

$imagenes = [
    'img/paquetes/vestido.jpg',
    'img/paquetes/salon.jpg',
    'img/paquetes/fotografia.jpg',
    'img/paquetes/decoracion.jpg',
    'img/paquetes/default.jpg',
    'img/paquetes/paquete6.jpg',
    'img/paquetes/paquete7.jpg',
    'img/paquetes/paquete8.jpg',
    'img/paquetes/paquete9.jpg'
];

$indice_proveedor = 0;

// Escapar textos para mostrarlos de forma segura.

$esc = static function ($valor) {
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};

// Cargar encabezado de la plataforma.

require_once __DIR__ . '/../layouts/header.php';

?>

<!-- ESTILOS DE LA PORTADA -->

<link
    rel="stylesheet"
    href="css/portada-romantica.css?v=4"
>

<!-- ====================================== -->
<!-- PORTADA PRINCIPAL                      -->
<!-- ====================================== -->

<section
    class="ri-hero"
    aria-labelledby="ri-hero-titulo"
>

    <div class="ri-hero-contenido">

        <span class="ri-sobretitulo">
            Recuerdos Inolvidables · Mis 15 años
        </span>

        <h1 id="ri-hero-titulo">

            Haz de tus <em>15 años</em>
            un recuerdo inolvidable

        </h1>

        <p>
            Encuentra proveedores para organizar
            una celebración a tu estilo.
        </p>

        <div class="ri-hero-acciones">

            <a
                href="#directorio-proveedores"
                class="ri-boton ri-boton-primario"
            >
                Explorar proveedores
            </a>

            <?php if ($esAdministradorProveedor): ?>

                <a
                    href="index.php?controller=evento&amp;action=index"
                    class="ri-boton ri-boton-secundario"
                >
                    Ver eventos
                </a>

            <?php endif; ?>

        </div>

    </div>

    <div
        class="ri-hero-ilustracion"
        aria-hidden="true"
    >

        <span>✦</span>

        <strong>15</strong>

        <span>✦</span>

    </div>

</section>

<!-- ====================================== -->
<!-- DIRECTORIO DE PROVEEDORES               -->
<!-- ====================================== -->

<section
    class="ri-directorio"
    id="directorio-proveedores"
    aria-labelledby="ri-directorio-titulo"
>

    <div class="ri-seccion-cabecera">

        <div>

            <span class="ri-sobretitulo">
                ENCUENTRA LO QUE NECESITAS
            </span>

            <h2 id="ri-directorio-titulo">
                Directorio de proveedores
            </h2>

            <p>
                Explora opciones para vestidos,
                salones, fotografía, decoración y más.
            </p>

        </div>

        <!-- CREAR PROVEEDOR -->

        <?php if ($esAdministradorProveedor): ?>

            <a
                class="ri-boton ri-boton-primario ri-admin-crear"
                href="index.php?controller=proveedor&amp;action=crear"
            >
                + Nuevo proveedor
            </a>

        <?php endif; ?>

    </div>

    <!-- ================================== -->
    <!-- TARJETAS DE PROVEEDORES            -->
    <!-- ================================== -->

    <div class="ri-proveedores-grid">

        <?php if (!empty($proveedores)): ?>

            <?php foreach ($proveedores as $p): ?>

                <?php

                // ID del proveedor.

                $id_proveedor = (int) (
                    $p['id_proveedor']
                    ?? $p['id']
                    ?? 0
                );

                // Nombre comercial.

                $nombre_proveedor = '';

                $posiblesNombres = [
                    'nombre_comercial',
                    'nombre_empresa',
                    'empresa',
                    'nombre_proveedor',
                    'nombre',
                    'razon_social',
                    'titulo'
                ];

                foreach ($posiblesNombres as $campo) {

                    if (!empty($p[$campo])) {

                        $nombre_proveedor = trim(
                            (string) $p[$campo]
                        );

                        break;
                    }

                }

                if ($nombre_proveedor === '') {
                    $nombre_proveedor = 'Proveedor sin nombre';
                }

                // Categoría.

                $categoria_proveedor = 'Proveedor';

                foreach (
                    [
                        'categoria',
                        'nombre_categoria',
                        'tipo'
                    ] as $campo
                ) {

                    if (!empty($p[$campo])) {

                        $categoria_proveedor = trim(
                            (string) $p[$campo]
                        );

                        break;
                    }

                }

                // Descripción.

                $descripcion_proveedor =
                    $p['descripcion']
                    ?? $p['descripcion_servicio']
                    ?? 'Sin descripción disponible';

                // Dirección.

                $direccion_proveedor =
                    !empty($p['direccion'])
                    ? $p['direccion']
                    : (
                        $p['ubicacion']
                        ?? 'Sin dirección registrada'
                    );

                // Teléfono informativo.

                $telefono_proveedor =
                    !empty($p['telefono'])
                    ? $p['telefono']
                    : (
                        $p['celular']
                        ?? 'Sin teléfono registrado'
                    );

                // Correo electrónico.

                $correo_proveedor =
                    !empty($p['email'])
                    ? trim((string) $p['email'])
                    : (
                        !empty($p['correo'])
                        ? trim((string) $p['correo'])
                        : ''
                    );

                $correo_valido = filter_var(
                    $correo_proveedor,
                    FILTER_VALIDATE_EMAIL
                );

                // Imagen de la tarjeta.

                $imagen_proveedor = $imagenes[
                    $indice_proveedor % count($imagenes)
                ];

                $indice_proveedor++;

                ?>

                <!-- =============================== -->
                <!-- TARJETA INDIVIDUAL              -->
                <!-- =============================== -->

                <article class="ri-proveedor-card">

                    <!-- IMAGEN -->

                    <div class="ri-proveedor-imagen">

                        <img
                            src="<?= $esc($imagen_proveedor) ?>"
                            alt="Imagen ilustrativa de <?= $esc($nombre_proveedor) ?>"
                            loading="lazy"
                        >

                    </div>

                    <!-- CATEGORÍA -->

                    <div class="ri-proveedor-superior">

                        <span class="ri-categoria">

                            <?= $esc($categoria_proveedor) ?>

                        </span>

                        <?php if (
                            !empty($p['destacado']) ||
                            !empty($p['es_destacado'])
                        ): ?>

                            <span class="ri-destacado">
                                ★ Destacado
                            </span>

                        <?php endif; ?>

                    </div>

                    <!-- INFORMACIÓN -->

                    <div class="ri-proveedor-contenido">

                        <h3>
                            <?= $esc($nombre_proveedor) ?>
                        </h3>

                        <p class="ri-descripcion">
                            <?= $esc($descripcion_proveedor) ?>
                        </p>

                        <!-- DIRECCIÓN -->

                        <p class="ri-dato">

                            <span aria-hidden="true">
                                ⌖
                            </span>

                            <?= $esc($direccion_proveedor) ?>

                        </p>

                        <!-- TELÉFONO -->

                        <p class="ri-dato">

                            <span aria-hidden="true">
                                ☎
                            </span>

                            <?= $esc($telefono_proveedor) ?>

                        </p>

                        <!-- CORREO -->

                        <p class="ri-dato">

                            <span aria-hidden="true">
                                ✉
                            </span>

                            <?= $correo_valido
                                ? $esc($correo_proveedor)
                                : 'Correo no disponible'
                            ?>

                        </p>

                    </div>

                    <!-- ================================== -->
                    <!-- BOTONES DEL PROVEEDOR              -->
                    <!-- ================================== -->

                    <div class="ri-proveedor-acciones">

                        <!-- ============================== -->
                        <!-- CONTACTO POR WHATSAPP          -->
                        <!-- ============================== -->

                        <!--
                            El formulario envía los datos
                            a SolicitudContactoController.

                            El controlador registra el
                            intento en solicitudes_contacto.

                            Después redirige a WhatsApp
                            con el mensaje preparado.
                        -->

                        <form
                            action="index.php?controller=solicitudContacto&amp;action=registrar"
                            method="POST"
                            target="_blank"
                        >

                            <!-- PROVEEDOR SELECCIONADO -->

                            <input
                                type="hidden"
                                name="id_proveedor"
                                value="<?= $id_proveedor ?>"
                            >

                            <!-- TOKEN DE SEGURIDAD -->

                            <input
                                type="hidden"
                                name="csrf"
                                value="<?= $esc($_SESSION['contacto_csrf']) ?>"
                            >

                            <!-- BOTÓN DE SOLICITUD -->

                            <button
                                type="submit"
                                class="ri-boton ri-boton-primario"
                            >
                                Solicitar información por WhatsApp
                            </button>

                        </form>

                        <!-- ============================== -->
                        <!-- GUARDAR EN MIS NOTAS            -->
                        <!-- ============================== -->

                        <form
                            action="index.php?controller=nota&amp;action=agregar"
                            method="POST"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $id_proveedor ?>"
                            >

                            <input
                                type="hidden"
                                name="csrf"
                                value="<?= $esc($_SESSION['notas_csrf']) ?>"
                            >

                            <button
                                type="submit"
                                class="ri-boton ri-boton-carrito"
                            >
                                Guardar en mis notas
                            </button>

                        </form>

                        <!-- ============================== -->
                        <!-- OPCIONES ADMINISTRATIVAS       -->
                        <!-- ============================== -->

                        <?php if ($esAdministradorProveedor): ?>

                            <div class="ri-acciones-admin">

                                <!-- EDITAR -->

                                <a
                                    href="index.php?controller=proveedor&amp;action=editar&amp;id=<?= $id_proveedor ?>"
                                >
                                    Editar
                                </a>

                                <!-- ELIMINAR -->

                                <a
                                    href="index.php?controller=proveedor&amp;action=eliminar&amp;id=<?= $id_proveedor ?>"
                                    onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');"
                                >
                                    Eliminar
                                </a>

                            </div>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="ri-vacio">
                No hay proveedores registrados
                por el momento.
            </p>

        <?php endif; ?>

    </div>

</section>

<!-- ====================================== -->
<!-- BENEFICIOS DE RECUERDOS INOLVIDABLES   -->
<!-- ====================================== -->

<section
    class="ri-beneficios"
    aria-label="Ventajas de Recuerdos Inolvidables"
>

    <div>

        <strong>
            ♡ A tu estilo
        </strong>

        <p>
            Compara las opciones disponibles
            y elige las que prefieras.
        </p>

    </div>

    <div>

        <strong>
            ✧ Organiza tu celebración
        </strong>

        <p>
            Consulta proveedores y servicios
            en un mismo lugar.
        </p>

    </div>

    <div>

        <strong>
            ◇ Encuentra inspiración
        </strong>

        <p>
            Descubre ideas para planear
            tus 15 años.
        </p>

    </div>

</section>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
