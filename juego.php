<?php
include 'cabecera.php';

echo $_SESSION['usuario'];  


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
                header('Location: partida.php?id_partida=' .$conexion->insert_id);
            }
            break;
        
        default:
            # code...
            break;
    }
}
?>

    <body>
        <div id="crear_partida">
            <form action="juego.php" method="get">
                <input type="hidden" name="act" value="nueva">
                <input type="hidden" name="act2" value="nueva2">
                <input type="submit" value="Nueva partida"/>
            </form>
        </div>
        <div id="tabla_partidas">
            <table>
                <thead>
                    <tr>
                        <td> Partida </td>
                        <td> Jugador 1 </td>
                        <td> Jugador 2 </td>
                    </tr>
                </thead>
                <tbody>
                
            <?php
            $consulta = $conexion->query("SELECT usuario, partidas.id FROM usuarios INNER JOIN partidas on player1=usuarios.id");
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
            ?>
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