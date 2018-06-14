  window.onload=function(){
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
  }

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
              var mensajes = document.getElementById("mensajes");
              var player1_DOM = document.getElementById("jugador1");
              var player2_DOM = document.getElementById("jugador2");
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
                  player1_DOM.setAttribute("class", "turno");
                  player2_DOM.removeAttribute("class");  

              }
              else if(turno==2)
              {
                  player2_DOM.setAttribute("class", "turno");
                  player1_DOM.removeAttribute("class");   
              }
              // mensajes.innerHTML = '';
              
               var arrayCeldas = document.getElementsByClassName('celda');
              //INTENTO DE METER IMÁGENES PERO RALENTIZAN DEMASIADO LA APLICACIÓN
              //  var imgX = document.createElement('img');
              //  imgX.src = "img/X.png";
              //  var imgO = document.createElement('img');
              //  imgO.src = "img/O.png";

               var winner = victoria(arrayPos, player1, player2, id_partida);

               console.log(winner);
               if(winner!=-1)
               {
                   player1_DOM.removeAttribute("class");
                   player2_DOM.removeAttribute("class");
                   //document.getElementById('winner').innerHTML="HA GANADO " + winner.toUpperCase();   
                   clearInterval(crono);
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

  function victoria(a, player1, player2, id_partida)
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

      if(winner == player1 || winner==player2)
      {
          var req = new XMLHttpRequest();
          var respuesta;
          req.open('GET', 'consultasAjax.php?winner=' + winner + '&id_partida=' + id_partida, true);
          
          req.addEventListener("load", function () {
            respuesta = req.response;
            console.log(respuesta);
          });
          req.send(null);
          return respuesta;

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

    
    