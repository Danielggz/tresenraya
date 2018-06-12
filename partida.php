<?php
include 'cabecera.php';
include 'login_check.php';

if(isset($_GET['id_partida']))
{
    $id_partida = $_GET['id_partida'];
    $idUser = $_SESSION['idUser'];
    $usuario = $_SESSION['usuario'];
    $turno = rand(1,2);
    
    $consulta = $conexion->query("UPDATE partidas SET player2=" .$_SESSION['idUser'] .", turno=$turno WHERE id=" .$id_partida);

    if($consulta)
    {
        $_SESSION['id_partida'] = $id_partida;
        header("Location:partida.php");
    }
}

if(isset($_GET['id_enjuego']))
{
    $id_partida = $_GET['id_enjuego'];
    $idUser = $_SESSION['idUser'];
    $usuario = $_SESSION['usuario'];

    $_SESSION['id_partida'] = $id_partida;
    header("Location:partida.php");
}


?>

<body>
    <div id="partida">

        <div id="titulo">
            <h1> Partida <span id='id_partida'><?php echo $_SESSION['id_partida']?></span></h1>
        </div>

        <h2 id='winner'></h2>

        <div id="jugadores">
            <div id="jugador1"> 
                <h2>Jugador 1</h2>
                <span id="user1">
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
            </span>
            </div>

            <div id="jugador2">
                <h2>Jugador 2</h2>
                <span id="user2">
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
            </span>
            </div>
        </div>

        <div>
            <table id="tablero">
                <tbody>
                    <tr id='col1'>
                        <td class='celda' id='c0'></td>
                        <td class='celda' id='c1'></td>
                        <td class='celda' id='c2'></td>                      
                    </tr>
                    <tr id='col2'>
                        <td class='celda' id='c3'></td>
                        <td class='celda' id='c4'></td>
                        <td class='celda' id='c5'></td> 
                    </tr>
                    <tr id='col3'>
                        <td class='celda' id='c6'></td>
                        <td class='celda' id='c7'></td>
                        <td class='celda' id='c8'></td>
                    </tr>
                </tbody>
                <!-- <tfoot>
                    <tr><td colspan=3>
                        <div id='boton_jugar'>
                            <input type="submit" id="inicioJuego" value="JUGAR!"/>
                        </div>
                    </td></tr>
                </tfoot> -->
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
    <script src='js/script.js'></script>
</body>
</html>