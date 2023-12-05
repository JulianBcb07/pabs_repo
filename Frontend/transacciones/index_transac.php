<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../src/transaccion.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>SOFTWARE S&L</title>
</head>

<body>
    <!-- HEADER-->
    <?php
    require_once('../../Backend/includes/header.php');
    ?>


    <section id="transacciones">
        <h3 style="font-weight: bold;">Transacciones</h3>
        <div id="buttons">
            <button onclick="primerTransaccion()" class="btn btn-success">Consultar</button>
            <button onclick="segundoTransaccion()" class="btn btn-danger">Agregar</button>
        </div>
        <div id="first-transaction" style="display: block;">
            <?php
            include '../../Backend/conexion.php';
            $resConsulta;

            function consultar($conn, $id_cliente)
            {
                $consulta = "SELECT * FROM clientes WHERE id_cliente = $id_cliente";
                $resConsulta = $conn->query($consulta);
                if (!$resConsulta) {
                    throw new Exception("Error en la consulta: " . $conn->error);
                }
                $cliente = $resConsulta->fetch_assoc();
            ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $cliente['id_cliente']; ?></td>
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['apellido']; ?></td>
                            <td><?php echo $cliente['telefono']; ?></td>
                            <td><?php echo $cliente['correo']; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php
            }

            function eliminar($conn, $id_cliente)
            {
                $consulta = "DELETE FROM clientes WHERE id_cliente = $id_cliente";
                $resEliminar = $conn->query($consulta);
                if (!$resEliminar) {
                    throw new Exception("Error al eliminar: " . $conn->error);
                }
                echo "Dato eliminado correctamente!";
            }

            $conn->begin_transaction();
            try {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id_cliente = $_POST['id_cliente'];
                    if (isset($_POST['consultar'])) {
                        consultar($conn, $id_cliente); //Llamar método consultar
                    } elseif (isset($_POST['eliminar'])) {
                        eliminar($conn, $id_cliente); //Llamar método eliminar
                    }
                }
                //sleep(8);
                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();
                echo "Error en la operación: " . $e->getMessage();
            }
            ?>

            <form method="post" action="" id="form-transaction-one">
                <h2>Consultar usuario</h2>
                <input type="text" id="id_cliente" class="input-group-text" name="id_cliente" required style="width:100%">
                <button type="submit" id="button" name="consultar" class="btn btn-success">Consultar</button>
                <button type="submit" id="button" name="eliminar" class="btn btn-danger">Eliminar</button>
            </form>
        </div>

        <div id="second-transaction" style="display: none;">
            <?php
            include '../../Backend/conexion.php';
            $resConsulta;
            function guardar($conn, $nombre, $descripcion, $precioConv)
            {
                $consulta = "INSERT INTO tipo_servicio (nombre, descripcion, preciokg) VALUES ('$nombre', '$descripcion', $precioConv)";
                $resConsulta = $conn->query($consulta);
                if (!$resConsulta) {
                    throw new Exception("Error en al guardar los datos: " . $conn->error);
                }
                echo "<h3>La información se guardó correctamente</h3>";
            }
            $conn->begin_transaction();
            try {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nombre = $_POST['nombre'];
                    $descripcion = $_POST['desc'];
                    $precio = $_POST['precio'];
                    $precioConv = floatval($precio);
                    guardar($conn, $nombre, $descripcion, $precioConv); //Llamar método guardar
                }
                //sleep(8);
                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();
                echo "Error en la operación: " . $e->getMessage();
            }
            ?>

            <form method="post" action="">
                <h2>Registrar tipo servicio</h2>
                <input class="input-group-text" type="text" placeholder="Nombre" name="nombre">
                <input class="input-group-text" type="text" placeholder="Descripción" name="desc">
                <input class="input-group-text" type="text" placeholder="Precio (kg)" name="precio">
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </section>

    <?php
    require_once('../../Backend/includes/footer.php');
    ?>

    <script>
        //SCRIPT PARA TRANSACCIONES
        var primeraTransaccion = document.getElementById("first-transaction");
        var segundaTransaccion = document.getElementById("second-transaction");

        function primerTransaccion() {
            if (primeraTransaccion.style.display === "none") {
                primeraTransaccion.style.display = "block";
                segundaTransaccion.style.display = "none";
            } else {
                primeraTransaccion.style.display = "none";
            }
        }

        function segundoTransaccion() {
            if (segundaTransaccion.style.display === "none") {
                segundaTransaccion.style.display = "block";
                primeraTransaccion.style.display = "none";
            } else {
                segundaTransaccion.style.display = "none";
            }
        }
    </script>

</body>

</html>