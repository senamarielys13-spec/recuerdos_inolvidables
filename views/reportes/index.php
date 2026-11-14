
<
<?php

require_once __DIR__ . '/../layouts/header.php';

// Mostrar textos de manera segura.
$esc = static function ($valor) {
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};

// Valores calculados desde ReporteController.
$totalUsuarios = (int) ($totalUsuarios ?? 0);
$totalProveedores = (int) ($totalProveedores ?? 0);
$totalServicios = (int) ($totalServicios ?? 0);
$totalContactos = (int) ($totalContactos ?? 0);
$contactosMes = (int) ($contactosMes ?? 0);
$proveedoresConsultados = (int) (
    $proveedoresConsultados ?? 0
);

$proveedoresMasConsultados =
    $proveedoresMasConsultados ?? [];

$contactosMensuales =
    $contactosMensuales ?? [];

$ultimosContactos =
    $ultimosContactos ?? [];

$proveedorMasConsultado =
    $proveedorMasConsultado ?? null;

// Máximo para representar las barras.
$maxContactos = 0;

foreach ($contactosMensuales as $fila) {
    $maxContactos = max(
        $maxContactos,
        (int) $fila['total_contactos']
    );
}

?>

<style>

/* PANEL DE ADMINISTRACIÓN */

.ri-panel {
    max-width: 1200px;
    margin: 35px auto 65px;
    padding: 0 18px;
    color: #6c4259;
    font-family: Arial, sans-serif;
}

.ri-panel h1,
.ri-panel h2 {
    font-family: Georgia, serif;
    color: #873d61;
}

.ri-panel h1 {
    font-size: 36px;
    margin: 7px 0 8px;
}

.ri-panel h2 {
    font-size: 22px;
    margin: 0 0 17px;
}

.ri-panel .ri-sub {
    color: #806b78;
    font-size: 14px;
    line-height: 1.7;
    margin: 0 0 24px;
}

.ri-panel .ri-eyebrow {
    color: #b25d83;
    font-size: 11px;
    letter-spacing: 2px;
    font-weight: bold;
}

/* TARJETAS DE ESTADÍSTICAS */

.ri-metricas {
    display: grid;
    grid-template-columns:
        repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 25px;
}

.ri-metrica,
.ri-panel-seccion {
    background: #fff;
    border: 1px solid #ecd8e2;
    border-radius: 16px;
    box-shadow: 0 4px 16px #ad54780d;
}

.ri-metrica {
    padding: 20px;
    min-width: 0;
}

.ri-metrica span {
    display: block;
    color: #816879;
    font-size: 13px;
    line-height: 1.5;
}

.ri-metrica strong {
    display: block;
    font-size: 26px;
    color: #95466e;
    margin: 11px 0 5px;
    overflow-wrap: anywhere;
}

/* SECCIONES */

.ri-panel-seccion {
    padding: 24px;
    margin-bottom: 22px;
}

.ri-panel-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* ENLACES ADMINISTRATIVOS */

.ri-admin-links {
    display: grid;
    grid-template-columns:
        repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.ri-admin-links a {
    background: #faf0f5;
    border: 1px solid #ebd4df;
    border-radius: 12px;
    padding: 16px;
    color: #873d61;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: background .2s ease;
}

.ri-admin-links a:hover {
    background: #f4dfeb;
}

/* TABLAS */

.ri-tabla-contenedor {
    overflow-x: auto;
}

.ri-panel table {
    border-collapse: collapse;
    width: 100%;
    font-size: 13px;
}

.ri-panel th,
.ri-panel td {
    text-align: left;
    padding: 11px 9px;
    border-bottom: 1px solid #f1e2e9;
    vertical-align: top;
}

.ri-panel th {
    color: #8c4969;
    background: #fcf5f8;
}

.ri-panel td {
    overflow-wrap: anywhere;
}

/* GRÁFICOS */

.ri-bar-row {
    display: grid;
    grid-template-columns: 85px 1fr 55px;
    gap: 12px;
    align-items: center;
    font-size: 13px;
    margin-bottom: 14px;
}

.ri-bar-track {
    height: 18px;
    border-radius: 8px;
    background: #f8eaf0;
    overflow: hidden;
}

.ri-bar {
    height: 100%;
    background: linear-gradient(
        90deg,
        #d68aaa,
        #a84b78
    );
    border-radius: 8px;
}

.ri-empty {
    font-size: 14px;
    line-height: 1.65;
    color: #806a77;
}

.ri-nota-informativa {
    background: #faf0f5;
    border: 1px solid #ebd4df;
    border-radius: 12px;
    padding: 16px;
    color: #795369;
    font-size: 13px;
    line-height: 1.7;
}

.ri-panel .ri-contador {
    display: inline-block;
    background: #f7e8f0;
    color: #91476b;
    padding: 5px 11px;
    border-radius: 30px;
    font-weight: bold;
}

/* RESPONSIVE */

@media (max-width: 800px) {
    .ri-metricas {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .ri-panel-grid {
        grid-template-columns: 1fr;
    }

    .ri-admin-links {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 480px) {
    .ri-metricas,
    .ri-admin-links {
        grid-template-columns: 1fr;
    }

    .ri-bar-row {
        grid-template-columns: 70px 1fr 40px;
        gap: 6px;
    }
}

</style>

<!-- PANEL PRINCIPAL -->

<section
    class="ri-panel"
    aria-labelledby="titulo-panel"
>

    <span class="ri-eyebrow">
        RECUERDOS INOLVIDABLES · ADMINISTRACIÓN
    </span>

    <h1 id="titulo-panel">
        Panel de administración
    </h1>

    <p class="ri-sub">
        Estadísticas calculadas a partir de los
        registros de usuarios, proveedores y
        solicitudes de información por WhatsApp.
    </p>

    <!-- TARJETAS DE ESTADÍSTICAS -->

    <div class="ri-metricas">

        <div class="ri-metrica">
            <span>
                Contactos iniciados
            </span>

            <strong>
                <?= $totalContactos ?>
            </strong>

            <span>
                Solicitudes registradas
            </span>
        </div>

        <div class="ri-metrica">
            <span>
                Contactos del mes
            </span>

            <strong>
                <?= $contactosMes ?>
            </strong>

            <span>
                Durante el mes actual
            </span>
        </div>

        <div class="ri-metrica">
            <span>
                Proveedores consultados
            </span>

            <strong>
                <?= $proveedoresConsultados ?>
            </strong>

            <span>
                De <?= $totalProveedores ?>
                proveedores registrados
            </span>
        </div>

        <div class="ri-metrica">
            <span>
                Usuarios
            </span>

            <strong>
                <?= $totalUsuarios ?>
            </strong>

            <span>
                <?= $totalServicios ?>
                servicios registrados
            </span>
        </div>

    </div>

    <!-- PROVEEDOR MÁS CONSULTADO -->

    <section class="ri-panel-seccion">

        <h2>Proveedor más consultado</h2>

        <?php if ($proveedorMasConsultado): ?>

            <p>
                <strong>
                    <?= $esc(
                        $proveedorMasConsultado[
                            'nombre_comercial'
                        ]
                    ) ?>
                </strong>
            </p>

            <p>
                <span class="ri-contador">
                    <?= (int) $proveedorMasConsultado[
                        'total_contactos'
                    ] ?>
                    contactos iniciados
                </span>
            </p>

        <?php else: ?>

            <p class="ri-empty">
                Todavía no hay solicitudes
                de información registradas.
            </p>

        <?php endif; ?>

    </section>

    <!-- GESTIÓN ADMINISTRATIVA -->

    <section class="ri-panel-seccion">

        <h2>Gestión del sistema</h2>

        <div class="ri-admin-links">

            <a href="index.php?controller=servicio&amp;action=index">
                Productos y servicios
            </a>

            <a href="index.php?controller=proveedor&amp;action=index">
                Proveedores
            </a>

            <a href="index.php?controller=categoria&amp;action=index">
                Categorías
            </a>

            <a href="index.php?controller=usuario&amp;action=index">
                Usuarios y personal
            </a>

            <a href="index.php?controller=evento&amp;action=index">
                Eventos
            </a>

            <a href="index.php?controller=reporte&amp;action=index">
                Actualizar estadísticas
            </a>

        </div>

    </section>

    <!-- ESTADÍSTICAS GRÁFICAS -->

    <div class="ri-panel-grid">

        <!-- CONTACTOS POR MES -->

        <section class="ri-panel-seccion">

            <h2>Contactos por mes</h2>

            <?php if (empty($contactosMensuales)): ?>

                <p class="ri-empty">
                    Todavía no hay contactos
                    registrados para mostrar
                    en el gráfico.
                </p>

            <?php else: ?>

                <?php foreach (
                    $contactosMensuales as $fila
                ): ?>

                    <?php

                    $cantidad = (int) (
                        $fila['total_contactos'] ?? 0
                    );

                    $ancho = $maxContactos > 0
                        ? round(
                            100 * $cantidad / $maxContactos,
                            1
                        )
                        : 0;

                    ?>

                    <div class="ri-bar-row">

                        <span>
                            <?= $esc($fila['periodo']) ?>
                        </span>

                        <div class="ri-bar-track">

                            <div
                                class="ri-bar"
                                style="width: <?= $ancho ?>%;"
                            ></div>

                        </div>

                        <strong>
                            <?= $cantidad ?>
                        </strong>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

        <!-- PROVEEDORES MÁS CONSULTADOS -->

        <section class="ri-panel-seccion">

            <h2>Proveedores más consultados</h2>

            <?php if (
                empty($proveedoresMasConsultados)
            ): ?>

                <p class="ri-empty">
                    Aún no se han registrado
                    solicitudes de información.
                </p>

            <?php else: ?>

                <div class="ri-tabla-contenedor">

                    <table>

                        <thead>
                            <tr>
                                <th>Proveedor</th>
                                <th>Contactos</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach (
                                $proveedoresMasConsultados as $fila
                            ): ?>

                                <tr>

                                    <td>
                                        <?= $esc(
                                            $fila[
                                                'nombre_comercial'
                                            ]
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int) $fila[
                                            'total_contactos'
                                        ] ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </section>

    </div>

    <!-- HISTORIAL DE CONTACTOS -->

    <section class="ri-panel-seccion">

        <h2>
            Últimos contactos iniciados
        </h2>

        <?php if (empty($ultimosContactos)): ?>

            <p class="ri-empty">
                No hay contactos registrados todavía.
            </p>

        <?php else: ?>

            <div class="ri-tabla-contenedor">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha y hora</th>
                            <th>Usuario</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (
                            $ultimosContactos as $contacto
                        ): ?>

                            <tr>

                                <td>
                                    <?= (int) $contacto[
                                        'id_solicitud'
                                    ] ?>
                                </td>

                                <td>
                                    <?= $esc(
                                        $contacto['fecha_envio']
                                    ) ?>
                                </td>

                                <td>
                                    <?= $esc(
                                        $contacto[
                                            'nombre_remitente'
                                        ]
                                    ) ?>
                                </td>

                                <td>
                                    <?= $esc(
                                        $contacto[
                                            'nombre_comercial'
                                        ]
                                    ) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </section>

    <!-- ACLARACIÓN SOBRE WHATSAPP -->

    <div class="ri-nota-informativa">

        <strong>
            Información sobre los registros
        </strong>

        <p>
            Los contactos registrados corresponden
            a solicitudes de apertura de WhatsApp
            realizadas desde Recuerdos Inolvidables.
            No confirman que el mensaje haya sido
            enviado, respondido o que se haya
            realizado una contratación.
        </p>

        <p>
            Los precios, acuerdos y pagos se gestionan
            directamente entre clientes y proveedores,
            fuera de la plataforma.
        </p>

    </div>

</section>

<?php

require_once __DIR__ . '/../layouts/footer.php';

?>
