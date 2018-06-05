<?php
include 'cabecera.php';
?>

    <body>
        <div id="formulario">
            <form action="login.php" method="post" id="formulario">
                <label for='usuario'>Nombre: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Introduce tu nombre de usuario" required>
                <label for='pwd'>Contraseña: </label>                
                <input type="password" name="pwd" id="pwd" placeholder="Introduce una contraseña" required>
                <input type="submit" id="enviar">
            </form>
        </div>

        <div id="mensajes">
        <?php
            if(isset($_POST['usuario']))
            {
                $usuario = $_POST['usuario'];
                $pwd = $_POST['pwd'];

                $resultado = $conexion->query("SELECT * from usuarios where usuario='" .$usuario ."' and pass='" .$pwd ."'");
                
                if($resultado->num_rows==0)
                {
                    echo "Error en el usuario o la contraseña";
                }
                else{
                    $arrayResult = $resultado->fetch_assoc(); //FETCH ASSOC PARA ARRAYS ASOCIATIVOS

                    //GUARDAR SESIÓN
                    $_SESSION['idUser'] = $arrayResult['id'];
                    $_SESSION['usuario'] = $arrayResult['usuario'];

                    foreach ($arrayResult as $key => $value) {
                        echo $key ."---->" .$value ."<br/>";
                    }
                    
                    header('Location: juego.php');

                    
                }
                
            }
        ?>
        </div>
    </body>
</html>