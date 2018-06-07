<?php
include 'cabecera.php';

if(isset($_GET['id_partida']))
{
    $id_partida = $_GET['id_partida'];
    $idUser = $_SESSION['idUser'];
    $usuario = $_SESSION['usuario'];
    
    $consulta = $conexion->query("UPDATE partidas SET player2=" .$_SESSION['idUser'] ." WHERE id=" .$id_partida);

    if($consulta)
    {
        $jugador2 = true;
        $_SESSION['id_partida'] = $id_partida;
        header("Location:partida.php");
    }

}


?>

<body>
    <div id="partida">

        <h1></h1>

        <div id="jugadores">
            <div id="jugador1"> 
                <h2>Jugador 1</h2>
            <?php
               $consulta = $conexion->query("SELECT usuario, partidas.player1 FROM usuarios INNER JOIN partidas on partidas.player1=usuarios.id WHERE partidas.id=" .$_SESSION['id_partida']);

                if($consulta->num_rows>0)
                {
                    while($partidas = $consulta->fetch_assoc())
                    {
                        echo $partidas['usuario'];
                    }
                }
            ?>
            </div>

            <div id="jugador2">
                <h2>Jugador 2</h2> 
                <script src='ajax_player2'></script>
            <?php  
            $consulta = $conexion->query("SELECT partidas.player2, usuario FROM usuarios INNER JOIN partidas on partidas.player2=usuarios.id WHERE partidas.id=" .$_SESSION['id_partida']);
          
            if($consulta->num_rows>0)
            {
                while($partidas = $consulta->fetch_assoc())
                {
                    echo $partidas['usuario'];
                }
            }
            else
            {
                echo "Esperando jugador..";
            }     
            ?>
            </div>
        </div>
        <div>
            <?php
            ?>
            <table id="tablero">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>          
        </div>
    </div>  

    <div id="mensajes">
        <?php
        if(isset($error))
        {
            echo $error;
        }
        ?>
    </div>
</body>
</html>