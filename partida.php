<?php
include 'cabecera.php';

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
                        <div id='boton_jugar'>
                            <input type="submit" id="inicioJuego" value="JUGAR!"/>
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
    var jugador;
    var turno;
    var celdas = document.getElementsByTagName('td');
    var botonInicio = document.getElementById('inicioJuego');
    var mensajes = document.getElementById("mensajes");

    actualizarTablero();    

    for(var i=0; i<celdas.length; i++)
    {
        if(celdas[i].innerHTML=='')
        {
            celdas[i].addEventListener('click', function(){
            actualizarCelda(this.id);  
            });
        }
        
    }

    cronoIni(ajax, 1000);
    // botonInicio.addEventListener("click", function()
    // {
        
    //     botonInicio.disabled = true;
    // });

    
    

    function ajax()
    {
        var id=document.getElementById('id_partida').innerText;

        // mensajes.innerHTML = 'Esperando al oponente.. '; 

        var req = new XMLHttpRequest();
        req.open('GET', 'consultasAjax.php?id=' + id, true);
        
        req.addEventListener("load", function () {
            
            document.getElementById("jugador2").innerHTML = `
            <h2>Jugador 2</h2> 
            ` + req.responseText;
            if(req.responseText!='Esperando jugador..')
            {
                clearInterval(crono);
                cronoIni(actualizarTablero, 1000);
            }
        });

        req.send(null);
    }  

    function actualizarCelda(id_celda)
    {
        var id_partida = document.getElementById("id_partida").innerHTML;

        if(turno == jugador)
        {
            var req = new XMLHttpRequest();
            req.open('GET', 'consultasAjax.php?id_celda=' + id_celda + '&id_partida=' + id_partida, true);
            
            req.addEventListener("load", function () {
                console.log(req.responseText);
                
            });
            req.send(null);
        }
    }

    function actualizarTablero()
    {
        var id_partida = document.getElementById("id_partida").innerHTML;
        
        var req = new XMLHttpRequest();
            req.open('GET', 'consultasAjax.php?id_tablero=' + id_partida, true);
            
            req.addEventListener("load", function () {
                var player1_style = document.getElementById("jugador1");
                var player2_style = document.getElementById("jugador2");
                var obj = JSON.parse(req.response);
                var arrayPos = JSON.parse(obj.celdas);
                var player1 = obj.player1;
                var player2 = obj.player2;
                turno = obj.turno;
                if(obj.usuario==player1)
                {
                    jugador = 1;
                }
                else
                {
                    jugador = 2;
                }

                if(turno==1)
                {
                    player1_style.setAttribute("class", "turno");
                    player2_style.removeAttribute("class");  

                }
                else if(turno==2)
                {
                    player2_style.setAttribute("class", "turno");
                    player1_style.removeAttribute("class");   
                }
                // mensajes.innerHTML = '';
                
                 var arrayCeldas = document.getElementsByClassName('celda');
                 var imgX = document.createElement('img');
                 imgX.src = "img/X.png";
                 var imgO = document.createElement('img');
                 imgO.src = "img/O.png";

                 var winner = victoria(arrayPos, player1, player2);
                 if(winner)
                 {
                     alert('GANA' + winner);
                 }
                 

                for(var i=0; i<arrayCeldas.length; i++)
                {
                    
                    if(arrayCeldas[i].innerHTML=='')
                    {
                        if(arrayPos[i]==player1)
                        {
                            arrayCeldas[i].innerHTML = 'X';
                            //arrayCeldas[i].appendChild(imgX);
                        }
                        if(arrayPos[i]==player2)
                        {
                            arrayCeldas[i].innerHTML = 'O';
                            // arrayCeldas[i].appendChild(imgO);
                        }
                    }

                    //victoria(arrayPos, player1, player2);
                   
                }
            });
            req.send(null);
    }

    function victoria(a, player1, player2)
    {
        var winner=0;
        if(a[0]==a[1] && a[1]==a[2])
        {
            winner = a[0];
        }
        if(a[3]==a[4] && a[4]==a[5])
        {
            winner = a[3];
        }
        if(a[6]==a[7] && a[7]==a[8])
        {
            winner = a[6];
        }
        if(a[0]==a[3] && a[3]==a[6])
        {
            winner = a[0];
        }
        if(a[1]==a[4] && a[4]==a[7])
        {
            winner = a[1];
        }
        if(a[2]==a[5] && a[5]==a[8])
        {
            winner = a[2];
        }
        if(a[0]==a[4] && a[4]==a[8])
        {
            winner = a[0];
        }
        if(a[2]==a[4] && a[4]==a[6])
        {
            winner = a[2];
        }

        if(winner == player1)
        {
            return 'winner1';
        }
        else if(winner==player2)
        {
            return 'winner2';
        }
        else if(winner==0)
        {
            return -1;
        }
    }

    function cronoIni(funcion,ms)
    {
        crono = setInterval(funcion, ms);
    }

    </script>
</body>
</html>