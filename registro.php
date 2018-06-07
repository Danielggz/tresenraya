<?php
include 'cabecera.php';
?>

    <body>
        <div id="formulario">
            <form action="registro.php" method="post" id="formulario">
                <label for='nombre'>Nombre: </label>
                <input type="text" name="nombre" id="nombre" placeholder="Introduce tu nombre completo" required>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Introduce un nombre de usuario"/>
                <label for='nombre'>Contraseña: </label>                
                <input type="password" name="pwd" id="pwd" placeholder="Introduce una contraseña" required>
                <label for='nombre'>Repita la contraseña: </label>
                <input type="password" name="pwd2" id="pwd2" placeholder="Repite la contraseña" required>
                <!-- <input type="file" id="avatar" name="avatar" accept="image/*">
                <input type="hidden" name="hiddenAvatar" id="hiddenAvatar"/> -->
                <input type="submit" id="enviar">
            </form>
        </div>

        <div id="mensajes">
        <?php
            if(isset($_POST['nombre']))
            {
                $nombre = $_POST['nombre'];
                $usuario = $_POST['usuario'];
                $pwd = $_POST['pwd'];
                $pwd2 = $_POST['pwd2'];
                // $avatar = $_POST['hiddenAvatar'];
                if($pwd != $pwd2)
                {
                    echo "Las contraseñas no coinciden :(";
                    exit();
                }

                $consulta = $conexion->query("INSERT INTO usuarios VALUES('', '" .$nombre ."', '" .$usuario ."', '" .$pwd ."')");
                
                if(!$consulta)
                {
                    echo "Hay un error en el registro";
                    exit();
                }
                else
                {
                    header('Location: login.php');
                }
            }
        ?>
        </div>
    </body>
</html>

