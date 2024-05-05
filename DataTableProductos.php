<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="">

    <!-- Bootstrap CSS -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        .img-producto {
            width: 125px; /* el ancho*/
            height: 125px; /*altura*/
            object-fit: cover; /* Esto asegura que la imagen se recorte para llenar el contenedor sin distorsionarse */
        }
    </style>
    <title>Consulta Productos!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="src/logot.png" alt="Logo de Abarrotes Los Ángeles" style="height: auto; width: 60px;">
                Abarrotes Los Ángeles
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menú</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="Login.html" target="_blank">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.html" target="_blank">Registrarse</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catálogo Productos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="RegProd.php">Insertar</a></li>
                                <li><a class="dropdown-item" href="ModProd.php">Modificar</a></li>
                                <li><a class="dropdown-item" href="DataTableProductos.php">Consultar</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar en Abarrotes Los Ángeles" aria-label="Search">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <br><br><br><br><br>
    <?php

    // Dirección o IP del servidor MySQL
    $host = "localhost";
    
    // Nombre de usuario del servidor MySQL
    $usuario = "root";
    // Contraseña del usuario
    $contrasena = "";
    // Nombre de la base de datos
    $baseDeDatos = "sistemaabarrotes"; 
    // Nombre de la tabla a trabajar
    $tabla = "productos";
    function Conectarse()
{
    global $host, $usuario, $contrasena, $baseDeDatos, $tabla;
    if (!($link = mysqli_connect($host, $usuario, $contrasena))) {
        echo "Error conectando a la base de datos.<br>";
        exit();
    } else {
        echo "Listo, estamos conectados.<br>";
    }
    if (!mysqli_select_db($link, $baseDeDatos)) {
        echo "Error seleccionando la base de datos.<br>";
        exit();
    } else {
        echo "Obtuvimos la base de datos $baseDeDatos sin problema.<br>";
    }

    // Consulta para obtener los datos de productos y categorías
    $query = "SELECT * FROM $tabla";
    $result = mysqli_query($link, $query);

    // Consulta adicional para obtener los nombres de las categorías
    $queryCategorias = "SELECT IdCategoria, Concepto FROM categorias";
    $resultCategorias = mysqli_query($link, $queryCategorias);
    $categorias = array();
    while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
        $categorias[$rowCategoria['IdCategoria']] = $rowCategoria['Concepto'];
    }
    mysqli_free_result($resultCategorias);

    // Devolver tanto la conexión como los resultados
    return array($link, $result, $categorias);
}

// Llamar a la función para obtener la conexión y los resultados
list($link, $result, $categorias) = Conectarse();


    
    ?>

    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Categoría</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Existencia</th>
                <th>Máximo</th>
                <th>Mínimo</th>
                <th>Descripción</th>
                <th>CostoPromedio</th>
                <th>Imagen</th>

            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
            
                echo "<td>" . $row["Codigo"] . "</td>";
                // Utiliza el nombre de la categoría en lugar del ID
                echo "<td>" . $categorias[$row["IdCategoria"]] . "</td>";
                echo "<td>" . ($row["Unidad"]) . "</td>";
                echo "<td>" . ($row["Precio"]) . "</td>";
                echo "<td>" . ($row["Existencia"]) . "</td>";
                echo "<td>" . ($row["Maximo"]) . "</td>";
                echo "<td>" . ($row["Minimo"]) . "</td>";
                echo "<td>" . ($row["Descripcion"]) . "</td>";
                echo "<td>" . ($row["CostoPromedio"]) . "</td>";
                echo "<td><img src={$row["Imagen"]} alt='Imagen de producto' class='img-producto'></td>";
                echo "</tr>";
            }            
            mysqli_free_result($result);
            mysqli_close($link);
            //echo "<a href='MiPaginaWeb.html' class='btn btn-primary'>Volver</a>";

            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Código</th>
                <th>Categorñia</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Existencia</th>
                <th>Máximo</th>
                <th>Mínimo</th>
                <th>Descripción</th>
                <th>CostoPromedio</th>
                <th>Imagen</th>
            </tr>

        </tfoot>
        
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#example').DataTable();
            windows.location.reload();
        });
    </script>

</body>

</html>