<?php 
include 'conexion.php';

if (!isset($_POST['codigo'])) { 
    // Formulario de registro de productos
    echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Registro de Productos</title>";

echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<form method='post' action='RegProd.php' enctype='multipart/form-data'>";
echo "<div class='row'>";

// Columna 1
echo "<div class='col'>";
echo "<div class='mb-3'>";
echo "<label for='codigo' class='form-label'>Código:</label>";
echo "<input type='text' class='form-control' id='codigo' name='codigo'>";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='idcategoria' class='form-label'>Categoría:</label>";
echo "<select class='form-select' id='idcategoria' name='idcategoria'>";
$tablac = "categorias";
$sqlCategorias = "SELECT IdCategoria, Concepto FROM $tablac";
$resultadoCategorias = mysqli_query($conexion, $sqlCategorias);
while($filaCategoria = mysqli_fetch_assoc($resultadoCategorias)){
    $idcategoria = $filaCategoria['IdCategoria'];
    $nombreCategoria=$filaCategoria['Concepto'];
    echo "<option value='$idcategoria'>$nombreCategoria</option>";
}
echo "</select>";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='unidad' class='form-label'>Unidad:</label>";
echo "<select class='form-select' id='unidad' name='unidad'>";
echo "<option>Pieza</option>";
echo "<option>Kg</option>";
echo "<option>g</option>";
echo "<option>Lt</option>";
echo "<option>ml</option>";
echo "</select>";
echo "</div>";
echo "</div>";

// Columna 2
echo "<div class='col'>";
echo "<div class='mb-3'>";
echo "<label for='precio' class='form-label'>Precio:</label>";
echo "<input type='text' class='form-control' id='precio' name='precio' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='existencia' class='form-label'>Existencia:</label>";
echo "<input type='text' class='form-control' id='existencia' name='existencia' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='maximo' class='form-label'>Máximo:</label>";
echo "<input type='text' class='form-control' id='maximo' name='maximo' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
echo "</div>";
echo "</div>";

// Columna 3
echo "<div class='col'>";
echo "<div class='mb-3'>";
echo "<label for='minimo' class='form-label'>Mínimo:</label>";
echo "<input type='text' class='form-control' id='minimo' name='minimo' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='descripcion' class='form-label'>Descripción:</label>";
echo "<input type='text' class='form-control' id='descripcion' name='descripcion'>";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='costopromedio' class='form-label'>Costo Promedio:</label>";
echo "<input type='text' class='form-control' id='costopromedio' name='costopromedio' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\">";
echo "</div>";

echo "<div class='mb-3'>";
echo "<label for='imagen' class='form-label'>Imagen:</label>";
echo "<input type='file' class='form-control' id='imagen' name='imagen'>";
echo "</div>"; 
echo "</div>"; // Fin de la columna 3
echo "</div>"; // Fin de la fila

echo "<div class='mb-3'>";
echo "<button type='submit' class='btn btn-primary'>Enviar</button>";
echo "<button type='reset' class='btn btn-secondary'>Limpiar</button>";
echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver</a>";
echo "</div>";

echo "</form>";
echo "</div>";
echo "</body>";
echo "</html>";

} else {
    $a = $_POST['codigo'];
    $b = $_POST['idcategoria'];
    $c = $_POST['unidad'];
    $d = $_POST['precio'];
    $e = $_POST['existencia'];
    $f = $_POST['maximo'];
    $g = $_POST['minimo'];
    $h = $_POST['descripcion'];
    $i = $_POST['costopromedio'];

    // Procesar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $temp_imagen = $_FILES['imagen']['tmp_name'];

        $ruta_imagen = "Images/" . $nombre_imagen;
        move_uploaded_file($temp_imagen, $ruta_imagen);

        $sql = "INSERT INTO productos (Codigo, IdCategoria, Unidad, Precio, Existencia, Maximo, Minimo, Descripcion, CostoPromedio, Imagen) 
        VALUES ('$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i', '$ruta_imagen')";

        // Ejecutar consulta
        if(mysqli_query($conexion, $sql)) {
            echo "Registro insertado correctamente.";
            echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver a Menú</a> <br>";
            
            echo "<a href='RegProd.php' class='btn btn-primary'>Volver a Registrar</a>";
        } else {
            echo "Error al insertar el registro: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al cargar el archivo: " . $_FILES['imagen']['error'];
    }
}
?>

