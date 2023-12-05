<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Frontend/src/main.css">
    <link rel="stylesheet" href="../../Frontend/src/bootstrap/css/bootstrap.min.css">
    <title>Software S&L</title>
</head>

<body>
    <?php
    require_once('../../Backend/includes/header.php');
    require_once('../../Backend/conexion.php');


    if (isset($_POST['consultar'])) {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];

        $stmt = $conn->prepare("CALL guardarCliente(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $apellidos, $telefono, $correo);

        $stmt->execute();

        $stmt->close();

        $mostrarResultados = true;
        echo "El procedimiento almacenado guardarCliente() se ejecutó";
    }

    ?>

    <section>
        <div class="container p-5 text-center">
            <h2>Ingresar un nuevo cliente</h2>

            <div class="row text-center p-4">
                <form method="post" action="" id="callSec3">
                    <fieldset>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="disabledTextInput" class="form-label">Nombre cliente</label>
                                <input type="text" id="disabledTextInput" name="nombre" class="form-control" placeholder="Disabled input">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="disabledTextInput" class="form-label">Apellidos</label>
                                <input type="text" id="disabledTextInput" name="apellido" class="form-control" placeholder="Disabled input">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="disabledTextInput" class="form-label">Telefono</label>
                                <input type="text" id="disabledTextInput" name="telefono" class="form-control" placeholder="Disabled input">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Correo electronico</label>
                                <input type="email" class="form-control" name="correo" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                        </div>
                        <button type="submit" id="button" name="consultar" class="btn btn-success">Crear cliente</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </section>

    <?php
    require_once('../../Backend/includes/footer.php');
    ?>

    <script src="../../Frontend/src/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>