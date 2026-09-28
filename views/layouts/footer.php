<!-- Cierre de contenedor si quedó alguno abierto -->
</div> 

<footer style="background: #ffffff; color: #444; border-top: 3px solid #e6196e; margin-top: 60px; padding: 40px 0 20px 0; width: 100%; box-shadow: 0 -4px 10px rgba(0,0,0,0.03);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
        
        <!-- Columna 1: Nombre de la Marca -->
        <div>
            <h3 style="color: #e6196e; font-size: 20px; font-weight: bold; margin-bottom: 12px; font-family: Arial, sans-serif;">
                Recuerdos Inolvidables 15
            </h3>
            <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0;">
                Haciendo de tu fiesta de 15 años un sueño hecho realidad con los mejores salones, vestidos, fotografía y servicios.
            </p>
        </div>

        <!-- Columna 2: Enlaces Rápidos (Módulos principales) -->
        <div>
            <h4 style="color: #333; font-size: 16px; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #f8bbd0; display: inline-block; padding-bottom: 4px;">
                Enlaces Rápidos
            </h4>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                <li>
                    <a href="index.php?controller=servicio&action=index" style="color: #555; text-decoration: none; font-size: 14px; font-weight: 500;" onmouseover="this.style.color='#e6196e'" onmouseout="this.style.color='#555'">
                        📦 Productos y Servicios
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=categoria&action=index" style="color: #555; text-decoration: none; font-size: 14px; font-weight: 500;" onmouseover="this.style.color='#e6196e'" onmouseout="this.style.color='#555'">
                        🏷️ Categorías
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=usuario&action=index" style="color: #555; text-decoration: none; font-size: 14px; font-weight: 500;" onmouseover="this.style.color='#e6196e'" onmouseout="this.style.color='#555'">
                        👥 Clientes / Usuarios
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=proveedor&action=index" style="color: #555; text-decoration: none; font-size: 14px; font-weight: 500;" onmouseover="this.style.color='#e6196e'" onmouseout="this.style.color='#555'">
                        🏭 Proveedores
                    </a>
                </li>
            </ul>
        </div>

        <!-- Columna 3: Información de Contacto -->
        <div>
            <h4 style="color: #333; font-size: 16px; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #f8bbd0; display: inline-block; padding-bottom: 4px;">
                Contacto
            </h4>
            <div style="display: flex; flex-direction: column; gap: 8px; font-size: 14px; color: #666;">
                <p style="margin: 0;">📧 contacto@recuerdosinolvidables.com</p>
                <p style="margin: 0;">📱 +57 322 4800189</p>
                <p style="margin: 0;">📍 Bogotá, Colombia</p>
            </div>
        </div>

    </div>

    <!-- Línea de Derechos Reservados -->
    <div style="max-width: 1200px; margin: 30px auto 0 auto; padding: 20px 20px 0 20px; border-top: 1px solid #f0f0f0; text-align: center; color: #888; font-size: 13px;">
        &copy; <?= date('Y') ?> Recuerdos Inolvidables 15 — Todos los derechos reservados.
    </div>
</footer>
</body>
</html>