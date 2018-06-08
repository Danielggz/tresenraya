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
                <tfoot>
                    <tr><td colspan=3>
                        <div id="crear_partida">
                            <form action="juego.php" method="get">
                                <input type="hidden" name="act" value="nueva">
                                <input type="hidden" name="act2" value="nueva2">
                                <input type="submit" value="JUGAR!"/>
                            </form>
                        </div>
                    </td></tr>
                </tfoot>
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


    <script>
    var crono;
    var celdas = document.getElementsByTagName('td');

    for(var i=0; i<celdas.length; i++)
    {
        celdas[i].addEventListener('click', function(){
          actualizarCelda(this.id);  
        })
    }

    cronoIni(ajax, 5000);
    

    function ajax()
    {
        var id=document.getElementById('id_partida').innerText;

        var req = new XMLHttpRequest();
        req.open('GET', 'consultasAjax.php?id=' + id, true);
        
        req.addEventListener("load", function () {
            
            document.getElementById("jugador2").innerHTML = `
            <h2>Jugador 2</h2> 
            ` + req.responseText;
            if(req.responseText!='Esperando jugador..')
            {
                clearInterval(crono);
                cronoIni(actualizarTablero, 2000);
            }
        });

        req.send(null);
    }  

    function actualizarCelda(id_celda)
    {
        var id_partida = document.getElementById("id_partida").innerHTML;

        var req = new XMLHttpRequest();
            req.open('GET', 'consultasAjax.php?id_celda=' + id_celda + '&id_partida=' + id_partida, true);
            
            req.addEventListener("load", function () {
                document.getElementById(id_celda).innerHTML = req.responseText;
                
            });
            req.send(null);
    }

    function actualizarTablero()
    {
        var id_partida = document.getElementById("id_partida").innerHTML;
        

        var req = new XMLHttpRequest();
            req.open('GET', 'consultasAjax.php?id_tablero=' + id_partida, true);
            
            req.addEventListener("load", function () {
                // document.getElementById(id_celda).innerHTML = req.responseText;
                var arrayPos = JSON.parse(req.response);
                var arrayCeldas = document.getElementsByClassName('celda');
                
                // for (const iterator in arrayCeldas) 
                // {
                //     arrayCeldas[iterator].innerHTML=arrayPos[iterator];
                // }
                for(var i=0; i<arrayCeldas.length; i++)
                {
                    arrayCeldas[i].innerHTML = arrayPos[i];
                }
            });
            req.send(null);
    }

    function cronoIni(funcion,ms)
    {
        crono = setInterval(funcion, ms);
    }

    </script>
</body>
</html>