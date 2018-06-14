<?php
include 'cabecera.php';
include 'login_check.php';
if(isset($_GET['act']))
{
    $accion = $_GET['act'];
    switch ($accion) {
        case 'nueva':
            $consulta = $conexion->query("INSERT INTO partidas (player1) VALUES (" .$_SESSION['idUser'] .")");
            if(!$consulta)
            {
                $error = "Error al crear la partida";
            }
            else
            {
                $_SESSION['id_partida'] = $conexion->insert_id;
                header('Location: partida.php');
            }
            break;
        
        default:
            # code...
            break;
    }
}
?>

    <body>
        <div id="titulo_juego">
            <h2>Usuario <?php echo $_SESSION['usuario']; ?></h2>
        </div>
        
        <section id='tablas'>
            <div id=tabla1>
                <table class="tabla">
                    <thead>
                        <tr>
                            <td colspan=3>Partidas existentes</td>
                        </tr>

                        <tr>
                            <td> Partida </td>
                            <td> Jugador 1 </td>
                            <td> Jugador 2 </td>
                        </tr>
                    </thead>
                    <tbody id='tabla_ajax1'>
                    
                <?php
                $consulta = $conexion->query("SELECT usuario, partidas.id FROM usuarios INNER JOIN partidas on player1=usuarios.id WHERE player2 IS NULL");
                if($consulta->num_rows>0)
                {
                    while($partidas = $consulta->fetch_assoc())
                    {
                        $id = $partidas['id'];
                        $usuario = $partidas['usuario'];
                        echo "<tr>";
                            echo "<td>" .$id ."</td>";
                            echo "<td>" .$usuario ."</td>";
                            echo "<td> <a href='partida.php?id_partida=" .$id ."'> Unirse a la partida </a> </td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<tr>";
                    echo "<td colspan=3>No hay partidas disponibles en este momento</td>";
                    echo "</tr>";
                } 
                ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan=3>
                            <div id="crear_partida">
                                <form action="juego.php" method="get">
                                    <input type="hidden" name="act" value="nueva">
                                    <input type="hidden" name="act2" value="nueva2">
                                    <input type="submit" value="Nueva partida"/>
                                </form>
                            </div>
                        </td></tr>
                    </tfoot>
                </table>
               
            </div>
            

            <div id="tabla2">
                <table class="tabla">
                    <thead>
                        <tr>
                            <td colspan=3>Partidas activas de <?php echo $_SESSION['usuario']; ?></td>
                        </tr>
                        <tr>
                            <td>Partida</td>
                            <td>Creador</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id='tabla_ajax2'>
                        <?php
                            $consulta = $conexion->query("SELECT usuario, player1, player2, partidas.id FROM usuarios INNER JOIN partidas on player1=usuarios.id WHERE player2='" .$_SESSION['idUser'] ."' or player1='" .$_SESSION['idUser'] ."'");
                            if($consulta->num_rows>0)
                            {
                                while($partidas = $consulta->fetch_assoc())
                                {
                                    $id = $partidas['id'];
                                    $usuario = $partidas['usuario'];
                                    echo "<tr>";
                                        echo "<td>" .$id ."</td>";
                                        echo "<td>" .$usuario ."</td>";
                                        echo "<td> <a href='partida.php?id_enjuego=" .$id ."'> Jugar </a> </td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        


        <div id="mensajes">
            <?php
            if(isset($error))
            {
                echo $error;
            }
            ?>
        </div>
        <script src='js/juegos.js'></script>
    </body>
</html>