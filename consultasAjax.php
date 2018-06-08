<?php
    session_start();
    $conexion = new mysqli("localhost", "Admin", "abc123.", "tresenrayaBD");

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $consulta = $conexion->query("SELECT partidas.player2, usuario FROM usuarios INNER JOIN partidas on partidas.player2=usuarios.id WHERE partidas.id=" .$id);
 
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
    }

    if(isset($_GET['id_celda']) && isset($_GET['id_partida']))
    {
        $id_celda = $_GET['id_celda'];
        $id_partida = $_GET['id_partida'];
        $id_user = $_SESSION['idUser'];


        $movimiento = $conexion->query("UPDATE partidas SET $id_celda = $id_user WHERE id = $id_partida AND $id_celda=0");
        if($movimiento)
        {
            echo "actualizado";
        }
    }

    if(isset($_GET['id_tablero']))
    {
        $id_partida = $_GET['id_tablero'];

        $consulta = $conexion->query("SELECT * FROM partidas WHERE id = $id_partida");
        if($consulta->num_rows>0)
        {
            $r = $consulta->fetch_assoc();
            $response = "[".$r["c0"] ."," .$r["c1"]."," .$r["c2"]."," .$r["c3"]."," .$r["c4"]."," .$r["c5"]."," .$r["c6"]."," .$r["c7"]."," .$r["c8"] ."]";
            echo $response;
        }
    }
?>