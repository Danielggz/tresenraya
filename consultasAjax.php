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

    if(isset($_GET['winner']) && isset($_GET['id_partida']))
    {
        $winner = $_GET['winner'];
        $id_partida = $_GET['id_partida'];
        
        $consulta = $conexion->query("UPDATE partidas SET estado=$winner WHERE id=$id_partida");
        if($consulta)
        {
            $select = $conexion->query("SELECT usuario from usuarios WHERE usuarios.id=$winner");
            if($select->num_rows>0)
            {
                $arrayDatos = $select->fetch_assoc();
                $winner = $arrayDatos['usuario'];
                echo $winner;
            }
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

    if(isset($_GET['tablas']))
    {   
        $obj = [];
        $HTMLcontent1 = '';
        $HTMLcontent2 = '';
        $consulta = $conexion->query("SELECT usuario, partidas.id FROM usuarios INNER JOIN partidas on player1=usuarios.id WHERE player2 IS NULL");
        if($consulta->num_rows>0)
        {
            while($partidas = $consulta->fetch_assoc())
            {
                $id = $partidas['id'];
                $usuario = $partidas['usuario'];
                $HTMLcontent1 = $HTMLcontent1  
                    ."<tr>
                    <td>$id</td>
                    <td>$usuario</td>
                    <td> <a href='partida.php?id_partida=$id'> Unirse a la partida </a> </td>
                    </tr>";
            }
        }
        else{
            $HTMLcontent1 =  $HTMLcontent1 ."<tr>
            <td colspan=3>No hay partidas disponibles en este momento</td>
            </tr>";
        } 
        


        $consulta2 = $conexion->query("SELECT usuario, partidas.id, turno, estado, player1, player2 FROM usuarios inner join partidas on player1=usuarios.id WHERE usuarios.id= ".$_SESSION['idUser'] ." or player2=" .$_SESSION['idUser'] ."");
            if($consulta2->num_rows>0)
            {
                while($partidas = $consulta2->fetch_assoc())
                {
                    $id = $partidas['id'];
                    $usuario = $partidas['usuario'];
                    $turno = $partidas['turno'];
                    $player1 = $partidas['player1'];
                    $player2 = $partidas['player2'];
                    
                    if($partidas['estado']!=0)
                    {
                        $HTMLcontent2 = $HTMLcontent2 
                            ."<tr>
                            <td>$id</td>
                            <td>$usuario</td>
                            <td> <a href='partida.php?id_enjuego=$id'> Finalizada </a> </td>
                            </tr>";
                    }
                    else 
                    {
                        switch ($turno) {
                            case 1:
                                if($player1 == $_SESSION['idUser'])
                                {
                                    $HTMLcontent2 = $HTMLcontent2 
                                    ."<tr>
                                    <td>$id</td>
                                    <td>$usuario</td>
                                    <td> <a href='partida.php?id_enjuego=$id'> Tu turno </a> </td>
                                    </tr>";
                                }
                                else
                                {
                                    $HTMLcontent2 = $HTMLcontent2 
                                    ."<tr>
                                    <td>$id</td>
                                    <td>$usuario</td>
                                    <td> <a href='partida.php?id_enjuego=$id'> Turno del oponente </a> </td>
                                    </tr>";
                                }
                                break;

                            case 2:
                                if($player2 == $_SESSION['idUser'])
                                {
                                    $HTMLcontent2 = $HTMLcontent2 
                                    ."<tr>
                                    <td>$id</td>
                                    <td>$usuario</td>
                                    <td> <a href='partida.php?id_enjuego=$id'> Tu turno </a> </td>
                                    </tr>";
                                }
                                else{
                                    $HTMLcontent2 = $HTMLcontent2 
                                    ."<tr>
                                    <td>$id</td>
                                    <td>$usuario</td>
                                    <td> <a href='partida.php?id_enjuego=$id'> Turno del oponente </a> </td>
                                    </tr>";
                                }
                                break;
                            
                            default:
                                $HTMLcontent2 = $HTMLcontent2 
                                ."<tr>
                                <td>$id</td>
                                <td>$usuario</td>
                                <td> <a href='partida.php?id_enjuego=$id'> Esperando oponente </a> </td>
                                </tr>";
                                break;
                        }
                    }

                }
            }

        $consulta3 = $conexion->query("SELECT usuario, turno from usuarios inner join partidas on player1=usuarios.id WHERE player2='" .$_SESSION['idUser'] ."' or player1='" .$_SESSION['idUser'] ."'");
        $arrayTurnos = [];
        if($consulta3->num_rows>0)
            {
                while($partidas = $consulta3->fetch_assoc())
                {
                    array_push($arrayTurnos, $partidas['turno']);
                }
            }

        $obj = [
            'content1'=> $HTMLcontent1,
            'content2'=> $HTMLcontent2,
            'turnos' => $arrayTurnos
        ];

        echo json_encode($obj); 

    }
?>