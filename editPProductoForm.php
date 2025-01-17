<?php
session_start();
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Nombre Proveedor";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="stylesxx.css">
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><?php echo htmlspecialchars($usuario); ?></li> <!-- Mostrar el nombre del proveedor -->
                <li><a href="Menu3.html" class="active">Promociones</a></li>
                <li>
                    <a href="PProductos.php">Productos</a>
                    <ul>
                        <li><a href="ConsultaPProd.php">Consultar Productos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Proveedores</a>
                    <ul>
                        <li><a href="ConsultaPProveedores.php">Consultar Proveedores</a></li>
                    </ul>
                </li> 
                <li><a href="logout.php">Cierre de sesión</a></li>
            </ul>
        </nav>
    </header>

<main>
    <h1>Editar Producto</h1>
    <div class="form-container">
        <form id="editProductForm">
            <div>
                <label for="NombreProd">Nombre del Producto:</label>
                <input type="text" id="NombreProd" name="NombreProd" placeholder="Ingresa el Nombre del producto" required>
            </div>
            <div>
                <label for="CodigoB">Código de Barras:</label>
                <input type="text" id="CodigoB" name="CodigoB" placeholder="Ingresa el Codigo de barras" required>
            </div>
            <div>
                <label for="FecCad">Fecha de Caducidad:</label>
                <input type="date" id="FecCad" name="FecCad" readonly required>
            </div>
            <div>
                <label for="Precio">Precio:</label>
                <input type="number" id="Precio" name="Precio" min="0" step="0.01" readonly placeholder="Ingresa el precio por pieza" required>
            </div>
            <div>
                <label for="Stock">Stock:</label>
                <input type="number" id="Stock" name="Stock" min="0" readonly placeholder="Ingresa el Numero de stock" required>
            </div>
            <div>
                <label for="Id_Categoria">Categoría:</label>
                <select id="Id_Categoria" name="Id_Categoria" required>
                    <option value="1">Galletas</option>
                    <option value="2">Chocolates</option>
                    <option value="3">Gelatinas</option>
                </select>
            </div>
            <div>
                <label for="Activo">Activo:</label>
                <input type="checkbox" id="Activo" name="Activo" disabled>
            </div>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</main>
<footer>
        <p>&copy;2024 Last Bite. Todos los derechos reservados.</p>
    </footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    function loadProductData(productId) {
        fetch(`getProductoById.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }
                document.getElementById('NombreProd').value = data.NombreProd;
                document.getElementById('CodigoB').value = data.CodigoB;
                document.getElementById('FecCad').value = data.FecCad;
                document.getElementById('Precio').value = data.Precio;
                document.getElementById('Stock').value = data.Stock;
                document.getElementById('Activo').checked = (data.Activo === '1');
                document.getElementById('Id_Categoria').value = data.Id_Categoria;
            })
            .catch(error => {
                console.error('Error al cargar los datos del producto', error);
                alert('Error al cargar los datos del producto');
            });
    }

    loadProductData(productId);

    document.getElementById('editProductForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(`updateProducto.php?id=${productId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Producto actualizado correctamente');
                window.location.href = 'ConsultaPProd.php';
            } else {
                alert(`Error al actualizar el producto: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error al actualizar el producto', error);
            alert('Error al actualizar el producto');
        });
    });
});
</script>

</body>
</html>
