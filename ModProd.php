<?php 
include 'conexion.php';

// Función para obtener la lista de productos desde la base de datos
function obtenerProductos() {
    global $conexion;
    $sql = "SELECT Codigo, Descripcion FROM productos";
    $result = mysqli_query($conexion, $sql);
    $productos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $productos[$row['Codigo']] = $row['Descripcion'];
    }
    return $productos;
}

// Función para obtener los datos de un producto específico por su ID
function obtenerProductoPorId($id) {
    global $conexion;
    $sql = "SELECT * FROM productos WHERE Codigo = '$id'";
    $result = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($result);
}

// Función para actualizar los datos de un producto
function actualizarProducto($id, $categoria, $unidad, $precio, $existencia, $maximo, $minimo, $descripcion, $costoPromedio, $ruta_imagen) {
    global $conexion;
    $sql = "UPDATE productos SET 
            IdCategoria = '$categoria', 
            Unidad = '$unidad', 
            Precio = '$precio', 
            Existencia = '$existencia', 
            Maximo = '$maximo', 
            Minimo = '$minimo', 
            Descripcion = '$descripcion', 
            CostoPromedio = '$costoPromedio',
            Imagen = '$ruta_imagen' 
            WHERE Codigo = '$id'";
    return mysqli_query($conexion, $sql);
}

if (isset($_POST['producto_seleccionado'])) {
    // ID del producto seleccionado
    $id_producto = $_POST['producto_seleccionado'];

    // Obtener los datos actuales del producto
    $producto = obtenerProductoPorId($id_producto);

    // Mostrar el formulario con los datos del producto para modificar
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Modificar Producto</title>";
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>";
    echo "</head>";
    echo "<body>";

    echo "<div class='container'>";
    echo "<h1>Modificar Producto</h1>";
    echo "<form method='post' enctype='multipart/form-data'>"; 

    echo "<input type='hidden' name='id_producto' value='" . $producto['Codigo'] . "'>";

    echo "<div class='row mb-3'>";
    echo "<div class='col'>";
    echo "<label for='idcategoria' class='form-label'>Categoría:</label>";
    echo "<select class='form-select' id='idcategoria' name='idcategoria' style='width: 100%'>";
    // Mostrar las categorías
    $tablac = "categorias";
    $sqlCategorias = "SELECT IdCategoria, Concepto FROM $tablac";
    $resultadoCategorias = mysqli_query($conexion, $sqlCategorias);
    while($filaCategoria = mysqli_fetch_assoc($resultadoCategorias)){
        $idcategoria = $filaCategoria['IdCategoria'];
        $nombreCategoria = $filaCategoria['Concepto'];
        echo "<option value='$idcategoria'>$nombreCategoria</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='unidad' class='form-label'>Unidad:</label>";
    echo "<select class='form-select' id='unidad' name='unidad' style='width: 100%'>";
    echo "<option>Pieza</option>";
    echo "<option>Kg</option>";
    echo "<option>g</option>";
    echo "<option>Lt</option>";
    echo "<option>ml</option>";
    echo "</select>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='precio' class='form-label'>Precio:</label>";
    echo "<input type='text' class='form-control' id='precio' name='precio' placeholder='" . $producto['Precio'] . "' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
    echo "</div>";
    echo "</div>";

    echo "<div class='row mb-3'>";
    echo "<div class='col'>";
    echo "<label for='existencia' class='form-label'>Existencia:</label>";
    echo "<input type='text' class='form-control' id='existencia' name='existencia' placeholder='" . $producto['Existencia'] . "' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='maximo' class='form-label'>Máximo:</label>";
    echo "<input type='text' class='form-control' id='maximo' name='maximo' placeholder='" . $producto['Maximo'] . "' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='minimo' class='form-label'>Mínimo:</label>";
    echo "<input type='text' class='form-control' id='minimo' name='minimo' placeholder='" . $producto['Minimo'] . "' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
    echo "</div>";
    echo "</div>";

    echo "<div class='row mb-3'>";
    echo "<div class='col'>";
    echo "<label for='descripcion' class='form-label'>Descripción:</label>";
    echo "<input type='text' class='form-control' id='descripcion' name='descripcion' placeholder='" . $producto['Descripcion'] . "'>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='costopromedio' class='form-label'>Costo Promedio:</label>";
    echo "<input type='text' class='form-control' id='costopromedio' name='costopromedio' value='" . $producto['CostoPromedio'] . "' readonly>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<label for='imagen' class='form-label'>Imagen:</label>";
    echo "<input type='file' class='form-control' id='imagen' name='imagen'>"; 
    echo "</div>";
    echo "</div>";

    echo "<div class='row mb-3'>";
    echo "<div class='col'>";
    echo "<button type='submit' class='btn btn-primary'>Guardar Cambios</button>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<button type='reset' class='btn btn-secondary'>Limpiar</button>";
    echo "</div>";

    echo "<div class='col'>";
    echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver</a>";
    echo "</div>";
    echo "</div>";

    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} elseif (isset($_POST['id_producto'])) {
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $categoria = $_POST['idcategoria'];
    $unidad = $_POST['unidad'];
    $precio = $_POST['precio'];
    $existencia= $_POST['existencia'];
    $maximo= $_POST['maximo'];
    $minimo = $_POST['minimo'];
    $descripcion = $_POST['descripcion'];
    $costoPromedio = $_POST['costopromedio'];
    
    // Procesar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener el nombre y la ruta temporal del archivo subido
        $nombre_imagen = $_FILES['imagen']['name'];
        $temp_imagen = $_FILES['imagen']['tmp_name'];

        // Construir la ruta completa de la imagen
        $ruta_imagen = "Images/" . $nombre_imagen;

        // Mover el archivo a su ubicación final
        move_uploaded_file($temp_imagen, $ruta_imagen);

        // Actualizar los datos del producto en la base de datos
        if (actualizarProducto($id_producto, $categoria, $unidad, $precio, $existencia, $maximo, $minimo, $descripcion, $costoPromedio, $ruta_imagen)) {
            echo "Producto actualizado correctamente.";
            echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver a Menú</a>";        
        } else {
            echo "Error al actualizar el producto.";
        }
    } else {
        echo "Error al cargar el archivo de imagen.";
    }
}  else {
    // Mostrar el formulario para seleccionar el producto a modificar
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Seleccionar Producto</title>";
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Seleccionar Producto</h1>";
    echo "<form method='post'>";
    echo "<div class='mb-3'>";
    echo "<label for='producto_seleccionado' class='form-label'>Seleccionar Producto:</label>";
    echo "<select class='form-select' id='producto_seleccionado' name='producto_seleccionado'>";
    
    $productos = obtenerProductos();
    foreach ($productos as $id => $nombre) {
        echo "<option value='$id'>$nombre</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Seleccionar</button>";
    echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver</a>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>
