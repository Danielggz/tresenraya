  window.onload=function(){
    var timer = this.setInterval(ajax, 5000);

  }
  function ajax(){
    var id=document.getElementById('id_partida').innerText;

    var req = new XMLHttpRequest();
    req.open('GET', 'consultasAjax.php?id=' .$id, true);
    
    req.addEventListener("load", function () {
      
        document.getElementById("jugador2").innerHTML = `
        <h2>Jugador 2</h2> 
        ` + req.responseText;
        if(req.responseText!='Esperando jugador..')
        {
          clearInterval(timer);
        }
    });

    req.send(null);
  }  
    
    