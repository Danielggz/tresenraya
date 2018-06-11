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

        $consulta = $conexion->query("SELECT turno FROM partidas WHERE id=$id_partida");
        $arrayDatos = $consulta->fetch_assoc();
        $turno = $arrayDatos['turno'];

        switch ($turno) {
            case 1:
                $movimiento = $conexion->query("UPDATE partidas SET $id_celda = $id_user, turno=2 WHERE id = $id_partida AND $id_celda=0");
                break;
            
            case 2:
                $movimiento = $conexion->query("UPDATE partidas SET $id_celda = $id_user, turno=1 WHERE id = $id_partida AND $id_celda=0");
                break;
        }

        if($movimiento)
        {
            echo $turno;
        }
    }

    if(isset($_GET['id_tablero']))
    {
        $id_partida = $_GET['id_tablero'];

        $consulta = $conexion->query("SELECT * FROM partidas WHERE id = $id_partida");
        if($consulta->num_rows>0)
        {
            $r = $consulta->fetch_assoc();
            $celdas = "[".$r["c0"] ."," .$r["c1"]."," .$r["c2"]."," .$r["c3"]."," .$r["c4"]."," .$r["c5"]."," .$r["c6"]."," .$r["c7"]."," .$r["c8"] ."]";
            $player1 = $r['player1'];
            $player2 = $r['player2'];
            $turno = $r['turno'];
            $usuario = $_SESSION['idUser'];
            $arrayObj = [
                'player1'=> $player1,
                'player2'=> $player2,
                'celdas'=> $celdas,
                'turno'=>$turno,
                'usuario'=>$usuario 
            ];
        }
        
        echo json_encode($arrayObj); 
    }
?>