
<?php
require_once __DIR__ . '/../layouts/header.php';

$esc = static function ($value): string {
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};
?>

<style>
.ri-notas-pagina {
    max-width: 1120px;
    margin: 38px auto 60px;
    padding: 0 16px;
    color: #694459;
}

.ri-notas-pagina h1 {
    font-family: Georgia, serif;
    font-weight: normal;
    font-size: clamp(28px, 3vw, 38px);
    color: #8b3b60;
    margin: 8px 0;
}

.ri-notas-etiqueta {
    letter-spacing: 2px;
    font-size: 11px;
    font-weight: bold;
    color: #b25e84;
}

.ri-notas-subtitulo {
    color: #816d79;
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 25px;
}

.ri-notas-grid {
    display: grid;
    grid-template-columns:
        repeat(auto-fit, minmax(min(100%, 330px), 1fr));
    gap: 18px;
}

.ri-nota {
    background: white;
    border: 1px solid #ecd6e0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 8px 24px rgba(125, 67, 96, .07);
}

.ri-nota h2 {
    font-family: Georgia, serif;
    color: #8b3b60;
    font-size: 23px;
    margin: 0 0 12px;
}

.ri-nota p {
    font-size: 13px;
    line-height: 1.6;
    color: #795d6f;
}

.ri-nota label {
    display: block;
    font-size: 13px;
    font-weight: bold;
    color: #884365;
    margin: 17px 0 8px;
}

.ri-nota textarea {
    display: block;
    width: 100%;
    box-sizing: border-box;
    min-height: 110px;
    resize: vertical;
    border: 1px solid #e7cde0;
    border-radius: 12px;
    padding: 12px;
    font-family: inherit;
    color: #694459;
    background: #fffafc;
}

.ri-nota-acciones {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 13px;
}

.ri-nota-boton {
    border: 0;
    border-radius: 22px;
    padding: 11px 19px;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    background: #a74d77;
    color: white;
    text-decoration: none;
    display: inline-block;
}

.ri-nota-boton-secundario {
    background: #fff;
    color: #a74d77;
    border: 1px solid #d8a5bc;
}

.ri-nota-vacia {
    background: #fff;
    border: 1px solid #ecd6e0;
    border-radius: 18px;
    text-align: center;
    padding: 40px 20px;
}
</style>

<section class="ri-notas-pagina">

    <span class="ri-notas-etiqueta">
        RECUERDOS INOLVIDABLES
    </span>

    <h1>Mis notas</h1>

    <p class="ri-notas-subtitulo">
        Guarda proveedores y anota qué necesitas
        preguntar o comparar para tu celebración.
        Estas notas son privadas de tu cuenta
        y no representan una compra.
    </p>

    <?php if (empty($notas)): ?>

        <div class="ri-nota-vacia">

            <h2>
                Aún no tienes proveedores guardados
            </h2>

            <p>
                Explora el directorio y selecciona
                «Guardar en mis notas».
            </p>

            <a
                class="ri-nota-boton"
                href="index.php?controller=proveedor&amp;action=index"
            >
                Explorar proveedores
            </a>

        </div>

    <?php else: ?>

        <div class="ri-notas-grid">

            <?php foreach ($notas as $nota): ?>

                <article class="ri-nota">

                    <h2>
                        <?= $esc($nota['nombre_comercial']) ?>
                    </h2>

                    <p>
                        <?= $esc($nota['descripcion']) ?>
                    </p>

                    <?php if (!empty($nota['telefono'])): ?>

                        <p>
                            <strong>Teléfono:</strong>
                            <?= $esc($nota['telefono']) ?>
                        </p>

                    <?php endif; ?>

                    <?php if (!empty($nota['email'])): ?>

                        <p>
                            <strong>Correo:</strong>
                            <?= $esc($nota['email']) ?>
                        </p>

                    <?php endif; ?>

                    <!-- GUARDAR OBSERVACIÓN -->

                    <form
                        method="post"
                        action="index.php?controller=nota&amp;action=guardar"
                    >

                        <input
                            type="hidden"
                            name="csrf"
                            value="<?= $esc($_SESSION['notas_csrf']) ?>"
                        >

                        <input
                            type="hidden"
                            name="id_nota"
                            value="<?= (int) $nota['id_nota'] ?>"
                        >

                        <label
                            for="observacion-<?= (int) $nota['id_nota'] ?>"
                        >
                            Mi nota personal
                        </label>

                        <textarea
                            id="observacion-<?= (int) $nota['id_nota'] ?>"
                            name="observacion"
                            maxlength="2000"
                            placeholder="Ejemplo: consultar disponibilidad, fecha y condiciones."
                        ><?= $esc($nota['observacion']) ?></textarea>

                        <div class="ri-nota-acciones">

                            <button
                                class="ri-nota-boton"
                                type="submit"
                            >
                                Guardar nota
                            </button>

                        </div>

                    </form>

                    <!-- ELIMINAR NOTA -->

                    <form
                        method="post"
                        action="index.php?controller=nota&amp;action=eliminar"
                        onsubmit="return confirm('¿Eliminar este proveedor de tus notas?');"
                    >

                        <input
                            type="hidden"
                            name="csrf"
                            value="<?= $esc($_SESSION['notas_csrf']) ?>"
                        >

                        <input
                            type="hidden"
                            name="id_nota"
                            value="<?= (int) $nota['id_nota'] ?>"
                        >

                        <div class="ri-nota-acciones">

                            <button
                                class="ri-nota-boton ri-nota-boton-secundario"
                                type="submit"
                            >
                                Eliminar de mis notas
                            </button>

                        </div>

                    </form>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
