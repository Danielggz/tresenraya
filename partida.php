<?php
include 'cabecera.php';
?>

<body>
    <div id="partida">

        <h1></h1>

        <div id="jugadores">
            <div id="jugador1"> 
                <h2>Jugador 1</h2>
            <?php
                echo $_GET['id_partida'];
            ?>
            </div>

            <div id="jugador2">
                <h2>Jugador 2</h2> 
            <?php
                echo $_SESSION['usuario'];
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
    
    </div>
</body>
</html>