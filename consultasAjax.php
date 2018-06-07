<?php
    $conexion = new mysqli("localhost", "Admin", "abc123.", "tresenrayaBD");

    if(isset($_GET['player2']))
    {
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
?>